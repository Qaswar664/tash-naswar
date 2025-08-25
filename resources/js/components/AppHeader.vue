<script setup lang="ts">
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import { NavigationMenu, NavigationMenuItem, NavigationMenuList } from '@/components/ui/navigation-menu';
import { Link, usePage } from '@inertiajs/vue3';
import { Menu } from 'lucide-vue-next';
import { computed, ref, onMounted, onBeforeUnmount } from 'vue';

// Types for CMS integration
interface NavItem {
    id: number
    title: string
    href: string
    order: number
    position: 'left' | 'right'
    is_active: boolean
    created_at?: string
    updated_at?: string
}

interface SiteSettings {
    id: number
    logo: string
    site_name: string
    is_active: boolean
}

// Props for CMS data (will be passed from parent component or Inertia)
interface Props {
    navItems?: NavItem[]
    siteSettings?: SiteSettings
}

const props = withDefaults(defineProps<Props>(), {
    navItems: () => [],
    siteSettings: () => ({
        id: 1,
        logo: '/images/logo.png',
        site_name: 'TASH',
        is_active: true
    })
})

const page = usePage();
const isMobileMenuOpen = ref(false);

const isCurrentRoute = computed(() => (url: string) => page.url === url);

const activeItemStyles = computed(
    () => (url: string) =>
        isCurrentRoute.value(url)
            ? 'bg-red-600 text-white rounded-md'
            : 'hover:bg-red-700 hover:text-white rounded-md py-1'
);

// Filter and sort navigation items based on CMS data
const leftNavItems = computed(() =>
    props.navItems
        .filter(item => item.is_active && item.position === 'left')
        .sort((a, b) => a.order - b.order)
)

const rightNavItems = computed(() =>
    props.navItems
        .filter(item => item.is_active && item.position === 'right')
        .sort((a, b) => a.order - b.order)
)

// Fallback navigation items (default when no CMS data is available)
const defaultNavItems: NavItem[] = [
    { id: 1, title: 'Home', href: '/home', order: 1, position: 'left', is_active: true },
    { id: 2, title: 'About us', href: '/about', order: 2, position: 'left', is_active: true },
    { id: 3, title: 'News', href: '/news', order: 1, position: 'right', is_active: true },
    { id: 4, title: 'Contact us', href: '/contact', order: 2, position: 'right', is_active: true },
];

// Use default items if no CMS data is provided
const displayLeftItems = computed(() =>
    leftNavItems.value.length > 0
        ? leftNavItems.value
        : defaultNavItems.filter(item => item.position === 'left')
)

const displayRightItems = computed(() =>
    rightNavItems.value.length > 0
        ? rightNavItems.value
        : defaultNavItems.filter(item => item.position === 'right')
)

// All items for mobile menu
const allNavItems = computed(() => [...displayLeftItems.value, ...displayRightItems.value])

// Auto-close mobile menu when switching to lg+
const handleResize = () => {
    if (window.innerWidth >= 1024) {
        isMobileMenuOpen.value = false;
    }
};

onMounted(() => {
    window.addEventListener('resize', handleResize);
});

onBeforeUnmount(() => {
    window.removeEventListener('resize', handleResize);
});

// Method to handle navigation item click (for analytics or other tracking)
const handleNavClick = (item: NavItem) => {
    // Future: Add analytics tracking, click events, etc.
    console.log('Navigation clicked:', item.title)
}
</script>

<template>
    <div>
        <div class=" bg-black">
            <div class="container mx-auto flex h-20 items-end justify-between px-4 md:max-w-4xl 2xl:max-w-6xl ">
                <!-- Logo (Mobile Only) -->
                <div class="flex lg:hidden items-center">
                    <Link href="/">
                    <img :src="props.siteSettings.logo" :alt="props.siteSettings.site_name" class="h-10 w-auto" />
                    </Link>
                </div>

                <!-- Desktop Nav -->
                <!-- Desktop Nav -->
                <div class="hidden lg:flex relative w-full items-end py-1">
                    <!-- Left Nav -->
                    <NavigationMenu class="flex items-end mb-1">
                        <NavigationMenuList class="flex items-end space-x-6">
                            <NavigationMenuItem v-for="item in displayLeftItems" :key="item.id"
                                class="relative flex items-end">
                                <Link
                                    :class="[activeItemStyles(item.href), 'text-sm font-semibold text-white tracking-wider   uppercase cursor-pointer px-3 flex items-end']"
                                    :href="item.href" @click="handleNavClick(item)">
                                {{ item.title }}
                                </Link>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>

                    <!-- Center Logo (absolute, always centered & scales naturally) -->
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 flex items-center z-50">
                        <Link href="/" class="flex items-center">
                        <img :src="props.siteSettings.logo" :alt="props.siteSettings.site_name"
                            class="max-h-24 w-auto object-contain" />
                        </Link>
                    </div>

                    <!-- Right Nav -->
                    <NavigationMenu class="flex items-end ml-auto mb-1">
                        <NavigationMenuList class="flex items-end space-x-6">
                            <NavigationMenuItem v-for="item in displayRightItems" :key="item.id"
                                class="relative flex items-end">
                                <Link
                                    :class="[activeItemStyles(item.href), 'text-sm font-semibold text-white tracking-wider uppercase cursor-pointer px-3 flex items-end']"
                                    :href="item.href" @click="handleNavClick(item)">
                                {{ item.title }}
                                </Link>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>
                </div>


                <!-- Mobile Menu -->
                <div class="flex lg:hidden">
                    <Sheet v-model:open="isMobileMenuOpen">
                        <SheetTrigger as-child>
                            <button class="p-2 text-white">
                                <Menu class="h-6 w-6" />
                            </button>
                        </SheetTrigger>
                        <!-- Custom position: below navbar -->
                        <SheetContent class="border-0 absolute left-0 top-16 w-full bg-black text-white p-4 shadow-md">
                            <div class="flex flex-col space-y-4">
                                <Link v-for="item in allNavItems" :key="item.id" :href="item.href"
                                    :class="[activeItemStyles(item.href), 'block px-4 py-2 text-lg uppercase']"
                                    @click="handleNavClick(item)">
                                {{ item.title }}
                                </Link>
                            </div>
                        </SheetContent>
                    </Sheet>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Custom styles for CMS integration */
.navigation-item-enter-active,
.navigation-item-leave-active {
    transition: opacity 0.3s ease;
}

.navigation-item-enter-from,
.navigation-item-leave-to {
    opacity: 0;
}


</style>