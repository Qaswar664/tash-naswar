<script setup lang="ts">
import { Sheet, SheetContent, SheetTrigger } from '@/components/ui/sheet';
import { NavigationMenu, NavigationMenuItem, NavigationMenuList } from '@/components/ui/navigation-menu';
import { Link, usePage } from '@inertiajs/vue3';
import { Menu } from 'lucide-vue-next';
import { computed, ref, onMounted, onBeforeUnmount } from 'vue';
import type { NavItem } from '@/types';

const page = usePage();
const isMobileMenuOpen = ref(false);

const isCurrentRoute = computed(() => (url: string) => page.url === url);

const activeItemStyles = computed(
    () => (url: string) =>
        isCurrentRoute.value(url)
            ? 'bg-red-600 text-white rounded-md'
            : 'hover:bg-red-700 hover:text-white rounded-md'
);

const leftNavItems: NavItem[] = [
    { title: 'Home', href: '/home' },
    { title: 'About us', href: '/about' },
];

const rightNavItems: NavItem[] = [
    { title: 'News', href: '/news' },
    { title: 'Contact us', href: '/contact' },
];

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
</script>

<template>
    <div>
        <div class="border-b border-sidebar-border/80 bg-black">
            <div class="mx-4 sm:mx-[10%] flex h-16 items-center justify-between px-4 md:max-w-7xl">
                <!-- Logo (Mobile Only) -->
                <div class="flex lg:hidden items-center">
                    <Link href="/">
                    <img src="/logo.png" alt="Logo" class="h-10 w-auto" />
                    </Link>
                </div>

                <!-- Desktop Nav -->
                <div class="hidden lg:flex lg:flex-1 justify-between w-full">
                    <!-- Left Nav -->
                    <NavigationMenu class="flex h-full items-stretch">
                        <NavigationMenuList class="flex h-full items-stretch space-x-2">
                            <NavigationMenuItem v-for="(item, index) in leftNavItems" :key="index"
                                class="relative flex h-full items-center">
                                <Link
                                    :class="[activeItemStyles(item.href), 'h-9 text-sm font-normal text-white uppercase cursor-pointer px-3 flex items-center']"
                                    :href="item.href">
                                {{ item.title }}
                                </Link>
                            </NavigationMenuItem>
                        </NavigationMenuList>
                    </NavigationMenu>

                    <!-- Center Logo -->
                    <div class="flex items-center justify-center px-6">
                        <Link href="/">
                        <img src="/logo.png" alt="Logo" class="h-10 w-auto" />
                        </Link>
                    </div>

                    <!-- Right Nav -->
                    <NavigationMenu class="flex h-full items-stretch">
                        <NavigationMenuList class="flex h-full items-stretch space-x-2">
                            <NavigationMenuItem v-for="(item, index) in rightNavItems" :key="index"
                                class="relative flex h-full items-center">
                                <Link
                                    :class="[activeItemStyles(item.href), 'h-9 text-sm font-normal text-white uppercase cursor-pointer px-3 flex items-center']"
                                    :href="item.href">
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
                                <Link v-for="(item, index) in [...leftNavItems, ...rightNavItems]" :key="index"
                                    :href="item.href"
                                    :class="[activeItemStyles(item.href), 'block px-4 py-2 text-lg uppercase']">
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
