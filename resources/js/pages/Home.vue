<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppHeader from '@/components/AppHeader.vue';
import { ref, reactive, onMounted, onBeforeUnmount } from 'vue';
import { BriefcaseIcon } from '@heroicons/vue/24/solid';
import { motion } from 'motion-v';

// Slider state
const currentSlide = ref(0);

const slides = [
    {
        id: 1,
        title: 'خوشبودار نسوار',
        buttonImage: '/images/read-more.webp',
        // image: '/images/red-pack.webp',
        image: '/images/red-pack-img.webp',
        bgImage: '/images/red-banner.webp',
        buttonText: 'Read More',
    },
    {
        id: 2,
        title: 'سخت نسوار',
        buttonImage: '/images/read-more.webp',
        // image: '/images/blue-pack.webp',
        image: '/images/blue-pack-img.webp',
        bgImage: '/images/blue-banner.webp',
        buttonText: 'Read More',
    },
    {
        id: 3,
        title: 'سادہ نسوار',
        buttonImage: '/images/read-more.webp',
        // image: '/images/green-pack-resize.webp',
        image: '/images/green-pack-img.webp',
        bgImage: '/images/green-banner.webp',
        buttonText: 'Read More',
    },
];

const products = [
    {
        id: 1,
        name: 'TASH COOL MINT',
        subtitle: 'Pure Mint, Pure Freshness',
        image: '/images/blue-pack-img.webp',
        color: 'blue',
    },
    {
        id: 2,
        name: 'TASH EXTRA STRONG',
        subtitle: 'Extra Strength, Extra Cool',
        image: '/images/green-pack-img.webp',
        color: 'green',
    },
    {
        id: 3,
        name: 'TASH CLASSIC',
        subtitle: 'Best Classic Taste and Kick',
        image: '/images/red-pack-img.webp',
        color: 'red',
    },
    {
        id: 4,
        name: 'TASH COOL MINT 2',
        subtitle: 'Pure Mint, Pure Freshness',
        image: '/images/blue-pack-img.webp',
        color: 'blue',
    },
    {
        id: 5,
        name: 'TASH EXTRA STRONG 2',
        subtitle: 'Extra Strength, Extra Cool',
        image: '/images/green-pack-img.webp',
        color: 'green',
    },
    {
        id: 6,
        name: 'TASH CLASSIC 2',
        subtitle: 'Best Classic Taste and Kick',
        image: '/images/red-pack-img.webp',
        color: 'red',
    },
    {
        id: 7,
        name: 'TASH COOL MINT 3',
        subtitle: 'Pure Mint, Pure Freshness',
        image: '/images/blue-pack-img.webp',
        color: 'blue',
    },
    {
        id: 8,
        name: 'TASH EXTRA STRONG 3',
        subtitle: 'Extra Strength, Extra Cool',
        image: '/images/green-pack-img.webp',
        color: 'green',
    },
    {
        id: 9,
        name: 'TASH CLASSIC 3',
        subtitle: 'Best Classic Taste and Kick',
        image: '/images/red-pack-img.webp',
        color: 'red',
    },
];

const currentProductSlide = ref(0);
const productSlides = ref<{ id: number; name: string; subtitle: string; image: string; color: string; }[][]>([]);

const nextProductSlide = () => {
    currentProductSlide.value =
        (currentProductSlide.value + 1) % productSlides.value.length;
};

const prevProductSlide = () => {
    currentProductSlide.value =
        (currentProductSlide.value - 1 + productSlides.value.length) % productSlides.value.length;
};

const goToProductSlide = (index: number) => {
    currentProductSlide.value = index;
};

// track which images are loaded
const loaded = reactive<Record<number | string, boolean>>({});

// preload list (bg + product + misc)
const preloadSources: string[] = [
    '/images/read-more.webp',
    '/images/price-img.webp',
    '/images/order-now.webp',
    // add product placeholders if you want them preloaded too
];

// Auto-slide timer handle
let timer: number | undefined;
let timerProduct: number | undefined;

onMounted(() => {
    // initialise loaded flags
    slides.forEach((s) => {
        loaded[s.id] = false;
        // also push bg and product into preload list
        preloadSources.push(s.bgImage, s.image);
    });

    // preload images via JS so browser caches them before we show the slide
    preloadSources.forEach((src) => {
        const img = new Image();
        img.src = src;
        img.onload = () => {
            // mark by src so we could use it later (optional)
            loaded[src] = true;
        };
    });

    // specifically preload background images and mark loaded by slide id
    slides.forEach((s) => {
        const bg = new Image();
        bg.src = s.bgImage;
        bg.onload = () => {
            loaded[s.id] = true;
        };
        // optionally preload product image too
        const p = new Image();
        p.src = s.image;
        p.onload = () => {
            loaded[`${s.id}-product`] = true;
        };
        // button/price images already in preloadSources above
    });

    // Group products into slides of 3
    const productsPerSlide = 3;
    for (let i = 0; i < products.length; i += productsPerSlide) {
        productSlides.value.push(products.slice(i, i + productsPerSlide));
    }

    // start auto-slide for hero
    timer = window.setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % slides.length;
    }, 5000);

    // start auto-slide for products
    timerProduct = window.setInterval(() => {
        nextProductSlide();
    }, 5000);
});

onBeforeUnmount(() => {
    if (timer) clearInterval(timer);
    if (timerProduct) clearInterval(timerProduct);
});

const nextSlide = () => {
    currentSlide.value = (currentSlide.value + 1) % slides.length;
};

const prevSlide = () => {
    currentSlide.value = (currentSlide.value - 1 + slides.length) % slides.length;
};

const goToSlide = (index: number) => {
    currentSlide.value = index;
};
</script>

<template>

    <Head title="Tash Naswar - Home">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
        <!-- Keep browser-level preloads (helpful) -->
        <link rel="preload" href="/images/red-banner.webp" as="image" />
        <link rel="preload" href="/images/blue-banner.webp" as="image" />
        <link rel="preload" href="/images/green-banner.webp" as="image" />
        <link rel="preload" href="/images/read-more.webp" as="image" />
        <link rel="preload" href="/images/price-img.webp" as="image" />
        <link rel="preload" href="/images/order-now.webp" as="image" />
    </Head>

    <div class="home min-h-screen bg-white">
        <AppHeader />

        <!-- Hero Banner Slider -->
        <section class="relative bg-black text-white min-h-[70vh] md:max-h-[80vh] overflow-hidden">
            <div class="absolute inset-0">
                <div class="absolute inset-0 bg-black/80"></div>
                <template v-for="(s, i) in slides" :key="s.id">
                    <img :src="s.bgImage"
                        class="bg-img absolute inset-0 w-full h-full object-cover transition-opacity duration-800 ease-in-out"
                        :class="{
                            'opacity-100': currentSlide === i && loaded[s.id],
                            'opacity-0': !(currentSlide === i && loaded[s.id])
                        }" :alt="`background-${s.id}`" loading="eager" width="1600" height="700" />
                </template>
            </div>

            <!-- Content and Product Image -->
            <Transition name="fade" mode="out-in">
                <div :key="currentSlide" class="relative w-full flex items-center min-h-[70vh] md:max-h-[80vh]"
                    aria-live="polite">
                    <div class="container mx-auto px-4 md:max-w-4xl 2xl:max-w-6xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-10 items-center">
                            <!-- Content -->
                            <div class="text-white relative text-center mb-8 md:text-right order-2 md:order-1">
                                <div class="flex flex-col items-center">
                                    <Transition name="fade" mode="out-in">
                                        <h1 :key="`title-${currentSlide}`" class="text-4xl md:text-6xl font-bold mb-6">
                                            {{ slides[currentSlide].title }}
                                        </h1>
                                    </Transition>
                                    <Transition name="fade" mode="out-in">
                                        <button :key="`button-${currentSlide}`"
                                            class="relative inline-flex items-center justify-center h-[80px] w-[320px] bg-no-repeat bg-cover bg-center transition-opacity hover:opacity-80"
                                            :style="{ backgroundImage: `url(${slides[currentSlide].buttonImage})` }"
                                            aria-label="Read more">
                                            <span class="text-black font-bold uppercase text-lg">
                                                {{ slides[currentSlide].buttonText }}
                                            </span>
                                        </button>
                                    </Transition>
                                </div>
                            </div>

                            <!-- Product Image -->
                            <div class="order-1 md:order-2 mt-4 sm:mt-0 flex justify-center">
                                <div
                                    class="relative w-full max-w-[360px] sm:max-w-[300px] aspect-[4/5] flex items-center justify-center">
                                    <Transition name="fade" mode="out-in">
                                        <img :key="`product-${currentSlide}`" :src="slides[currentSlide].image"
                                            alt="Product" class="w-full h-full object-contain rounded-xl" width="300"
                                            height="375" loading="lazy" />

                                    </Transition>

                                    <!-- Price Tag -->
                                    <Transition name="fade" mode="out-in">
                                        <div :key="`price-${currentSlide}`"
                                            class="absolute top-0 sm:-top-4 -left-4 h-[80px] w-[100px] bg-no-repeat bg-contain bg-center"
                                            :style="{ backgroundImage: `url(/images/price-img.webp)` }">
                                            <div
                                                class="absolute inset-0 flex items-center justify-center transform -rotate-12 text-black">
                                                <span class="flex items-center">
                                                    <span class="text-base font-bold">Rs.</span>
                                                    <span
                                                        class="font-bold text-4xl sm:text-5xl leading-none rubik ml-1">30</span>
                                                </span>
                                            </div>
                                        </div>
                                    </Transition>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Transition>

            <!-- Order Now Button (outside of any transform animation) -->
            <div class="fixed bottom-20 right-4 md:right-78 z-50">
                <Link href="/order">
                <img src="/images/order-now.webp" alt="Order Now"
                    class="w-20 h-20 sm:w-20 sm:h-20 md:w-28 md:h-28 rounded-full hover:scale-110 transition"
                    width="160" height="160" loading="eager" />
                </Link>
            </div>
        </section>

        <!-- Welcome Section with Motion Animation -->
        <motion.section class="bg-black text-white py-4 sm:py-8 w-full flex items-center justify-center"
            :initial="{ opacity: 0, y: 50 }" :whileInView="{ opacity: 1, y: 0 }"
            :transition="{ duration: 0.8, ease: 'easeOut' }" :viewport="{ once: true }">
            <div class="container mx-auto px-4 md:max-w-4xl 2xl:max-w-6xl text-center">
                <h2 class="text-xl md:text-2xl font-bold mb-6">WELCOME TO TASH NASWAR</h2>
                <p class="max-w-xl 2xl:max-w-2xl 2xl:mb-4 text-sm md:text-base mx-auto text-gray-300 leading-relaxed ">
                    TASH is more than just a brand - it's a bold fusion of tradition, quality, and
                    modern innovation. We haven't just produced Naswar - we've redefined it for the
                    needs of today's market.
                </p>
            </div>
        </motion.section>

        <!-- Features Section with Motion Animation -->
        <motion.section class="relative overflow-hidden py-8 bg-white" :initial="{ opacity: 0, y: 50 }"
            :whileInView="{ opacity: 1, y: 0 }" :transition="{ duration: 0.8, ease: 'easeOut', delay: 0.2 }"
            :viewport="{ once: true }">
            <div class="container mx-auto px-4 md:max-w-4xl 2xl:max-w-6xl relative z-10">

                <div
                    class="flex flex-col sm:flex-row justify-between items-center gap-10 md:gap-16  py-12 sm:py-8 lg:py-0 px-0 md:px-28 font-semibold text-sm md:text-base text-center sm:text-left">
                    <div class="flex items-center justify-center sm:justify-start">
                        <img src="/images/Brain-img.webp" alt="Heading Left"
                            class="w-16 h-16 sm:w-20 sm:h-20 aspect-square object-contain" loading="lazy" />
                        <h5 class="ml-4">
                            <span class="hidden md:block">State-of-the-Art<br>Facility</span>
                            <span class="block md:hidden">State-of-the-Art Facility</span>
                        </h5>
                    </div>

                    <div class="flex items-center justify-center sm:justify-start">
                        <img src="/images/Box-img.webp" alt="Heading Right"
                            class="w-16 h-16 sm:w-20 sm:h-20 aspect-square object-contain" loading="lazy" />
                        <h5 class="ml-4">
                            <span class="hidden md:block">Food-Grade<br>Packaging</span>
                            <span class="block md:hidden">Food-Grade Packaging</span>
                        </h5>
                    </div>
                </div>

                <div class="flex  justify-center items-center gap-2 mt-0">
                    <div class="h-[1px] w-full bg-[#ECECEC]"></div>
                    <img src="/images/leaf.webp" alt="leaf" class="w-16 h-16  object-contain" />
                    <div class="h-[1px] w-full bg-[#ECECEC]"></div>
                </div>
            </div>

            <img src="/images/leave-img.webp" alt="Leaf" loading="eager" width="192" height="192"
                class="absolute -top-20 right-0 rotate-6 z-0" />
        </motion.section>


        <!-- Products Section with Motion Animation -->
        <motion.section class="py-4" :initial="{ opacity: 0, y: 50 }" :whileInView="{ opacity: 1, y: 0 }"
            :transition="{ duration: 0.8, ease: 'easeOut', delay: 0.4 }" :viewport="{ once: true }">
            <div class="container mx-auto md:max-w-4xl 2xl:max-w-6xl">
                <!-- Section Header -->
                <div class=" flex justify-center items-end font-bold text-gray-800">
                    <img class="w-12 h-auto pr-4" src="/images/leaf-icon.webp" alt="leaf" />
                    <h5 class="leading-tight md:leading-none text-base md:text-2xl">BOLD FLAVOUR. TRUE TRADITION</h5>
                    <img class="w-12 h-auto pl-4" src="/images/sparrow-icon.webp" alt="leaf" />
                </div>

                <!-- Products Slider -->
                <div class="relative overflow-hidden py-8">
                    <div class="flex transition-transform duration-500 ease-in-out"
                        :style="{ transform: `translateX(-${currentProductSlide * 100}%)` }">
                        <!-- Each Group Slide -->
                        <div v-for="(group, groupIndex) in productSlides" :key="groupIndex"
                            class="w-full flex-shrink-0 px-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-[2px] ">
                                <motion.div v-for="product in group" :key="product.id" class="text-center mb-8 md:mb-0"
                                    :initial="{ opacity: 0, scale: 0.9 }" :whileInView="{ opacity: 1, scale: 1 }"
                                    :transition="{ duration: 0.5, delay: (product.id % 3) * 0.2 }"
                                    :viewport="{ once: true }">
                                    <div class="mb-4 md:mb-6">
                                        <!-- <div class="w-full flex md:h-[290px] lg:h-[340px]  overflow-visible">
                                            <img :src="product.image"
                                                class="h-auto max-h-full  w-full  shadow-[0px_50px_35px_-50px_rgba(0,_0,_0,_0.8)]" />
                                        </div> -->
                                        <div
                                            class="w-full flex aspect-[1240/1500] md:h-[290px] lg:h-[340px] 2xl:h-[440px] overflow-visible">
                                            <img :src="product.image"
                                                class="w-full h-full object-cover shadow-[0px_50px_35px_-50px_rgba(0,_0,_0,_0.8)]"
                                                alt="{{ product.name }}" />
                                        </div>

                                    </div>
                                    <h3 class="font-bold text-base md:text-lg mb-2">{{ product.name }}</h3>
                                    <p class="text-gray-600 text-sm">{{ product.subtitle }}</p>
                                </motion.div>
                            </div>
                        </div>
                    </div>


                </div>

                <!-- Pagination Dots -->
                <div class="text-center mt-4">
                    <div class="inline-flex space-x-2">
                        <div v-for="(_, index) in productSlides" :key="index"
                            class="w-6 h-2 rounded-full cursor-pointer"
                            :class="currentProductSlide === index ? 'bg-red-600 w-8' : 'bg-white border border-[#ECECEC] w-4'"
                            @click="goToProductSlide(index)"></div>
                    </div>
                </div>
                <div class="flex  justify-center items-center gap-2 py-8 md:py-12">
                    <div class="h-[1px] w-full bg-[#ECECEC]"></div>
                    <img src="/images/leaf.webp" alt="leaf" class="w-16 h-16  object-contain" />
                    <div class="h-[1px] w-full bg-[#ECECEC]"></div>
                </div>
                <!-- Product grains -->
                <div class="relative">
                    <img src="/images/grain.webp" alt="Product Grain"
                        class="absolute -left-[150px] -top-[240px] -translate-x-1/2 w-full h-[240px] object-contain z-10" />
                </div>
            </div>
        </motion.section>


        <!-- Footer with Motion Animation -->
        <motion.footer class="pb-8 md:pb-0 md:py-12" :initial="{ opacity: 0, y: 50 }"
            :whileInView="{ opacity: 1, y: 0 }" :transition="{ duration: 0.8, ease: 'easeOut', delay: 0.6 }"
            :viewport="{ once: true }">
            <div class="container mx-auto px-4 md:max-w-4xl 2xl:max-w-6xl">
                <!-- Responsive grid with equal borders -->
                <div
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-2  sm:divide-y-0 sm:divide-x divide-[#ECECEC]">
                    <div class="pt-4 sm:pt-0 sm:pr-4">
                        <h3 class="font-semibold mb-4 text-sm md:text-base">WORKING HOURS</h3>
                        <div class="space-y-2 text-xs ">
                            <p>Monday - Friday: 9am - 5pm</p>
                            <p>Saturday - OFF</p>
                            <p>Sunday - OFF</p>
                        </div>
                    </div>
                    <!-- Social Network -->
                    <div class="pt-4 sm:pt-0 sm:px-4">
                        <h3 class="font-semibold mb-4 text-sm md:text-base">SOCIAL NETWORK</h3>
                        <div class="flex space-x-3">
                            <a href="#"
                                class=" rounded-full flex items-center justify-center hover:bg-blue-700 transition">
                                <img src="/images/facebook.webp" alt="Facebook" class="w-8 h-8" />
                            </a>
                            <a href="#"
                                class=" rounded-full flex items-center justify-center hover:bg-pink-700 transition">
                                <img src="/images/instagram.webp" alt="Instagram" class="w-8 h-8" />
                            </a>
                            <a href="#"
                                class=" rounded-full flex items-center justify-center hover:bg-blue-600 transition">
                                <img src="/images/linkedin.webp" alt="LinkedIn" class="w-8 h-8" />
                            </a>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="pt-4 sm:pt-0 sm:px-4">
                        <h3 class="font-semibold mb-4 text-sm md:text-base">ADDRESS</h3>
                        <div class="space-y-2 text-xs ">
                            <p>Near Adda Plot Roundabout,</p>
                            <p>Allama Iqbal Road Lahore,</p>
                            <p>Pakistan</p>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="pt-4 sm:pt-0 sm:pl-6">
                        <h3 class="font-semibold mb-4 text-sm md:text-base">CONTACT</h3>
                        <div class="space-y-2 text-xs">
                            <p class="flex items-center space-x-2">
                                <span>Email:</span>
                                <a href="mailto:info@alphatobaccopk.com" class="hover:text-blue-600">
                                    info@alphatobaccopk.com
                                </a>
                            </p>
                            <p class="flex items-center space-x-2">
                                <span>Contact:</span>
                                <a href="tel:+923221111611" class="hover:text-blue-600">
                                    +92 0322 1111 611
                                </a>
                            </p>
                        </div>
                    </div>
                </div>


            </div>
        </motion.footer>
        <!-- Bottom Footer -->
        <div class="border-t border-[#ECECEC] mt-4 md:mt-8 py-4 text-center">
            <p class="text-xs  ">
                Tash Naswar©Copyright 2025. All rights reserved.
            </p>
        </div>

        <div class="relative">
            <a href="https://wa.me/923221111611" target="_blank"
                class="absolute bottom-12 md:bottom-8 right-8 z-50 flex items-center space-x-2">
                <img src="/images/whatsapp.webp" alt="WhatsApp"
                    class="w-16 h-16 m-0 object-contain absolute right-20 rounded-full border border-white shadow-md" />
                <!-- Text -->
                <div class="text-xs text-white bg-gray-800 rounded-r-2xl py-2 pl-4 pr-2">
                    Need help?<br />Chat with us
                </div>
            </a>
        </div>
        <!-- Warning Section with Motion Animation -->
        <motion.section class="relative h-[200px] w-full bg-center  bg-cover bg-no-repeat"
            style="background-image: url('/images/biscut.webp');" :initial="{ opacity: 0, y: 50 }"
            :whileInView="{ opacity: 1, y: 0 }" :transition="{ duration: 0.8, ease: 'easeOut', delay: 0.8 }"
            :viewport="{ once: true }">
            <div class="h-full w-full bg-black/50 flex  justify-center text-center">
                <h2 class="text-white text-xs py-6 px-4">
                    <span class="text-red-600 text-sm">Warning:</span> This product contains nicotine, which is
                    addictive and
                    not risk-free. For use
                    by
                    adults only.
                </h2>
            </div>
        </motion.section>
    </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.8s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

.fade-enter-to,
.fade-leave-from {
    opacity: 1;
}

.bg-img {
    will-change: opacity;
}

img {
    display: block;
}
</style>
