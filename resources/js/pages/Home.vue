<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import AppHeader from '@/components/AppHeader.vue';
import { ChevronLeft, ChevronRight } from 'lucide-vue-next';
import { ref, onMounted, onBeforeUnmount } from 'vue';


// Slider state
const currentSlide = ref(0);

const slides = [
    {
        id: 1,
        title: 'خوشبودار نسوار',
        buttonImage: 'images/read-more.png', // Replace with actual button image path
        image: '/images/red-pack.png', // Replace with actual product image path
        bgImage: '/images/red-banner.png', // Replace with actual background image path
        buttonText: 'Read More'
    },
    {
        id: 2,
        title: 'سخت نسوار',
        buttonImage: '/images/read-more.png', // Replace with actual button image path
        image: '/images/blue-pack.png', // Replace with actual product image path
        bgImage: '/images/blue-banner.png', // Replace with actual background image path
        buttonText: 'Read More'
    },
    {
        id: 3,
        title: 'سادہ نسوار',
        buttonImage: '/images/read-more.png', // Replace with actual button image path
        image: '/images/green-pack-resize.png', // Replace with actual product image path
        bgImage: '/images/green-banner.png', // Replace with actual background image path
        buttonText: 'Read More'
    },

];


const products = [
    {
        id: 1,
        name: 'TASH COOL MINT',
        subtitle: 'Pure Mint, Pure Freshness',
        image: '/api/placeholder/300/400', // Replace with actual image path
        color: 'blue',
    },
    {
        id: 2,
        name: 'TASH EXTRA STRONG',
        subtitle: 'Extra Strength, Extra Cool',
        image: '/api/placeholder/300/400', // Replace with actual image path
        color: 'green',
    },
    {
        id: 3,
        name: 'TASH CLASSIC',
        subtitle: 'Best Classic Taste and Kick',
        image: '/api/placeholder/300/400', // Replace with actual image path
        color: 'red',
    },
];

// Auto-slide functionality
onMounted(() => {
    const timer = setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % slides.length;
    }, 5000);

    onBeforeUnmount(() => {
        clearInterval(timer);
    });
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

    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <div class="home min-h-screen bg-white">
        <AppHeader />

        <!-- Hero Banner Slider -->
        <section class="relative  bg-black text-white">
            <Transition name="fade-slide" mode="out-in">
                <div :key="currentSlide" class="relative w-full flex items-center min-h-[70vh] md:max-h-[80vh]" :style="{
                    backgroundImage: `url(${slides[currentSlide].bgImage})`,
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                }">
                    <div class="container mx-auto   px-4 md:max-w-4xl 2xl:max-w-6xl">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10 items-center">

                            <!-- Content -->

                            <div class="text-white relative text-center md:text-right order-2 md:order-1">
                                <!-- Wrapper to align title + button together -->
                                <div class="flex flex-col items-center ">

                                    <!-- Title -->
                                    <h1 class="text-4xl md:text-6xl font-bold mb-6">
                                        {{ slides[currentSlide].title }}
                                    </h1>

                                    <!-- Button with background image + text inside -->
                                    <button
                                        class="relative inline-flex items-center justify-center h-[80px] w-[320px] bg-no-repeat bg-cover bg-center transition-opacity hover:opacity-80"
                                        :style="{ backgroundImage: `url(${slides[currentSlide].buttonImage})` }">
                                        <span class="text-black font-bold uppercase text-lg">
                                            {{ slides[currentSlide].buttonText }}
                                        </span>
                                    </button>

                                </div>
                            </div>

                            <!-- Product Image -->
                            <div class="order-1 md:order-2 mt-4 sm:mt-0 flex justify-center">
                                <div
                                    class="relative w-full max-w-[360px] sm:max-w-[300px] aspect-[4/5] flex items-center justify-center ">

                                    <!-- Product -->
                                    <img :src="slides[currentSlide].image" alt="Product"
                                        class="w-full h-full object-contain rounded-xl " />

                                    <!-- Price Tag -->
                                    <div class="absolute top-0 sm:-top-4 -left-4 h-[80px] w-[100px] bg-no-repeat bg-contain bg-center"
                                        :style="{ backgroundImage: `url(/images/price-img.png)` }">
                                        <div
                                            class="absolute inset-0 flex items-center justify-center transform -rotate-12 text-black">
                                            <span class="flex items-center">
                                                <span class="text-base font-bold">Rs.</span>
                                                <span
                                                    class="font-bold text-4xl sm:text-5xl leading-none rubik ml-1">30</span>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Order Now Button -->
                                    <!-- <div class="absolute -bottom-20 sm:-bottom-28 right-2 sm:right-8 z-50">
                                    <Link href="/order">
                                    <img src="/images/order-now.png" alt="Order Now"
                                        class="w-28 h-28 sm:w-36 sm:h-36 md:w-40 md:h-40 rounded-full  hover:scale-110 transition" />
                                    </Link>
                                </div> -->
                                    <div class="fixed bottom-8 right-4 md:right-76 z-50">
                                        <Link href="/order">
                                        <img src="/images/order-now.png"
                                            class="w-20 h-20 sm:w-36 sm:h-36 md:w-40 md:h-40 rounded-full hover:scale-110 transition" />
                                        </Link>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </Transition>
        </section>


        <!-- Welcome Section -->
        <section class="bg-black text-white py-8  w-full flex items-center justify-center">
            <div class="container mx-auto px-4 md:max-w-4xl 2xl:max-w-6xl">

                <h2 class="text-3xl font-bold mb-6">WELCOME TO TASH NASWAR</h2>
                <p class="max-w-xl mx-auto text-gray-300 leading-relaxed ">
                    TASH is more than just a brand - it's a bold fusion of tradition, quality, and
                    modern innovation. We haven't just produced Naswar - we've redefined it for the
                    needs of today's market.
                </p>

                <!-- Features -->
                <!-- <div class="grid md:grid-cols-2 gap-8 max-w-2xl mx-auto">
                    <div class="flex items-center justify-center space-x-4">
                        <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center">
                            <div class="text-2xl">💡</div>
                        </div>
                        <div class="text-left">
                            <h3 class="font-semibold text-lg">State-of-the-Art</h3>
                            <p class="text-gray-400">Facility</p>
                        </div>
                    </div>
                    <div class="flex items-center justify-center space-x-4">
                        <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center">
                            <div class="text-2xl">📦</div>
                        </div>
                        <div class="text-left">
                            <h3 class="font-semibold text-lg">Food-Grade</h3>
                            <p class="text-gray-400">Packaging</p>
                        </div>
                    </div>
                </div> -->
            </div>
        </section>

        <!-- Products Section -->
        <section class="bg-gray-100 py-16">
            <div class="max-w-7xl mx-auto px-4">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <div class="text-4xl mb-4">♠</div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">
                        <span class="text-black">♠</span> BOLD FLAVOUR. TRUE TRADITION
                        <span class="text-black">♠</span>
                    </h2>
                </div>

                <!-- Products Grid -->
                <div class="grid md:grid-cols-3 gap-8">
                    <div v-for="product in products" :key="product.id" class="text-center">
                        <div class="mb-6 relative">
                            <div :class="[
                                product.color === 'blue' ? 'bg-blue-600' :
                                    product.color === 'green' ? 'bg-green-600' : 'bg-red-600',
                                'p-6 rounded-lg mx-auto max-w-xs shadow-lg',
                            ]">
                                <div class="text-white text-center">
                                    <div class="text-2xl font-bold mb-2">TASH</div>
                                    <div class="text-sm mb-2">
                                        {{ product.color === 'blue' ? 'سیخت نسوار' :
                                            product.color === 'green' ? 'سادہ نسوار' : 'خوشبودار نسوار' }}
                                    </div>
                                    <div class="text-2xl">♠</div>
                                </div>
                            </div>
                        </div>
                        <h3 class="font-bold text-lg mb-2">{{ product.name }}</h3>
                        <p class="text-gray-600 text-sm">{{ product.subtitle }}</p>
                    </div>
                </div>

                <!-- Moving Slider Indicator -->
                <div class="text-right mt-8 mr-8">
                    <span class="text-gray-600 text-sm">Moving Slider</span>
                    <div class="flex justify-end mt-2">
                        <svg width="50" height="30" viewBox="0 0 50 30" class="text-gray-400">
                            <path d="M5 15 Q25 5 45 15" stroke="currentColor" stroke-width="2" fill="none" />
                            <path d="M40 10 L45 15 L40 20" stroke="currentColor" stroke-width="2" fill="none" />
                        </svg>
                    </div>
                </div>

                <!-- Pagination Dots -->
                <div class="text-center mt-8">
                    <div class="inline-flex space-x-2">
                        <div class="w-3 h-3 bg-red-600 rounded-full"></div>
                        <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                    </div>
                </div>
            </div>
        </section>



        <!-- Footer -->
        <footer class="bg-black text-white py-12">
            <div class="max-w-7xl mx-auto px-4">
                <div class="grid md:grid-cols-4 gap-8">
                    <!-- Working Hours -->
                    <div>
                        <h3 class="font-bold mb-4 text-white">WORKING HOURS</h3>
                        <div class="space-y-1 text-sm text-gray-400">
                            <p>Monday - Friday: 9am - 5pm</p>
                            <p>Saturday - OFF</p>
                            <p>Sunday - OFF</p>
                        </div>
                    </div>

                    <!-- Social Network -->
                    <div>
                        <h3 class="font-bold mb-4 text-white">SOCIAL NETWORK</h3>
                        <div class="flex space-x-3">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs">f</span>
                            </div>
                            <div class="w-8 h-8 bg-pink-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs">@</span>
                            </div>
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <span class="text-white text-xs">in</span>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div>
                        <h3 class="font-bold mb-4 text-white">ADDRESS</h3>
                        <div class="text-sm text-gray-400">
                            <p>Near Adda Plot Roundabout,</p>
                            <p>Allama Iqbal Road Lahore,</p>
                            <p>Pakistan</p>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="font-bold mb-4 text-white">CONTACT</h3>
                        <div class="text-sm text-gray-400">
                            <p>Email: info@tashnaswarcoop.com</p>
                            <p>Contact: +92 0322 1111 611</p>
                        </div>
                    </div>
                </div>

                <!-- Bottom Footer -->
                <div class="border-t border-gray-800 mt-12 pt-8 text-center">
                    <div class="text-4xl mb-4">♠</div>
                    <p class="text-sm text-gray-400 mb-4">
                        Tash Naswar™ Copyright 2024. All rights reserved.
                    </p>
                    <p class="text-xs text-red-400">
                        <strong>Warning:</strong> This product contains nicotine, which is addictive and not risk-free.
                        For use by adults only.
                    </p>
                </div>
            </div>
        </footer>

        <!-- WhatsApp Float Button -->
        <div class="fixed bottom-8 left-8 z-50">
            <button
                class="bg-green-500 text-white rounded-full w-16 h-16 flex items-center justify-center hover:bg-green-600 transition-colors shadow-lg">
                <span class="text- coworkers2xl">📱</span>
            </button>
            <div class="absolute -top-8 left-20 text-xs text-gray-600 bg-white px-2 py-1 rounded shadow-md">
                Direct from<br />whatsapp
            </div>
        </div>
    </div>
</template>

<style scoped>
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: opacity 0.8s ease, transform 0.8s ease;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
    opacity: 0;
    transform: translateX(30px);
}

.fade-slide-enter-to,
.fade-slide-leave-from {
    opacity: 1;
    transform: translateX(0);
}

/* Add your custom styles here */
</style>