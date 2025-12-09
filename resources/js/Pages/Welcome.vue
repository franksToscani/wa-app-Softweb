<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

defineProps({
  canLogin: { type: Boolean, default: false },
  canRegister: { type: Boolean, default: false },
  isAdmin: { type: Boolean, default: false },
  posts: { type: Array, default: () => [] },
  products: { type: Array, default: () => [] },
  laravelVersion: { type: String, required: true },
  phpVersion: { type: String, required: true }
})

</script>

<template>
  <Head title="Welcome" />

  <AuthenticatedLayout :isAdmin="isAdmin">
    <div class="min-h-screen bg-gradient-to-b from-white via-neutral-50 to-neutral-100">
      <main class="mx-auto w-full max-w-7xl px-6 py-16">

      <!-- Hero section for welcome page -->
      <section class="grid gap-12 lg:grid-cols-2 lg:items-center mb-20">
        <div>
          <div class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-purple-500 rounded-full px-4 py-2 mb-6">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <span class="text-sm font-semibold text-white">Piattaforma All-in-One</span>
          </div>
          <h1 class="text-5xl font-extrabold leading-tight text-neutral-900 sm:text-6xl bg-gradient-to-r from-neutral-900 to-neutral-700 bg-clip-text text-transparent">Crea, vendi e condividi con WA</h1>
          <p class="mt-6 max-w-xl text-xl text-neutral-600 leading-relaxed">Una piattaforma semplice e potente per gestire prodotti, post e ordini. Design pulito, performance eccellenti e tutti gli strumenti che ti servono per partire subito.</p>

          <div class="mt-8 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <Link v-if="canRegister" :href="route('register')">
              <PrimaryButton class="shadow-lg hover:shadow-xl transition-shadow">Inizia ora — è gratis </PrimaryButton>
            </Link>
            <Link v-if="canLogin" :href="route('login')" class="text-sm font-medium text-neutral-700 hover:text-primary-600 transition-colors">Oppure accedi →</Link>
          </div>

          <div class="mt-12 grid grid-cols-2 gap-6 sm:grid-cols-4">
            <div class="group flex flex-col items-start space-y-2">
              <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
              </div>
              <strong class="text-base font-bold text-neutral-900">Prodotti</strong>
              <span class="text-sm text-neutral-600">Gestisci cataloghi e stock</span>
            </div>
            <div class="group flex flex-col items-start space-y-2">
              <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
              </div>
              <strong class="text-base font-bold text-neutral-900">Ordini</strong>
              <span class="text-sm text-neutral-600">Traccia e processa vendite</span>
            </div>
            <div class="group flex flex-col items-start space-y-2">
              <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
              <strong class="text-base font-bold text-neutral-900">Media</strong>
              <span class="text-sm text-neutral-600">Carica immagini e video</span>
            </div>
            <div class="group flex flex-col items-start space-y-2">
              <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-rose-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
              </div>
              <strong class="text-base font-bold text-neutral-900">Sicurezza</strong>
              <span class="text-sm text-neutral-600">Autenticazione integrata</span>
            </div>
          </div>
        </div>

        <div class="order-first lg:order-last">
          <div class="group rounded-3xl bg-gradient-to-br from-primary-600 via-purple-500 to-pink-500 p-1 shadow-xl hover:shadow-2xl transition-all duration-300">
            <div class="rounded-3xl bg-white p-8 lg:p-10 hover:bg-gradient-to-br hover:from-white hover:to-neutral-50 transition-colors">
              <div class="relative">
                <div class="absolute -inset-4 bg-gradient-to-r from-primary-500 to-purple-500 rounded-full blur-2xl opacity-20 group-hover:opacity-30 transition-opacity"></div>
                <img src="/images/logo.svg" alt="WA logo" class="relative mx-auto h-32 w-32 group-hover:scale-110 transition-transform duration-300" />
              </div>
              <p class="mt-8 text-center text-lg text-neutral-700 leading-relaxed">Interfaccia pulita e intuitiva — prova a registrarti per vedere la demo del pannello amministrativo.</p>
              <div class="mt-8 flex justify-center">
                <Link v-if="canRegister" :href="route('register')">
                  <PrimaryButton class="shadow-lg hover:shadow-xl transition-shadow">Prova la demo </PrimaryButton>
                </Link>
              </div>
            </div>
          </div>
        </div>

      </section>

      <!-- Side-by-side lists: posts (left) and products (right) -->
      <section class="grid gap-8 lg:grid-cols-2 mb-20">
        <!-- Posts column -->
        <div>
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
              </svg>
            </div>
            <h2 class="text-3xl font-bold text-neutral-900">Ultimi articoli</h2>
          </div>
          <div class="space-y-4">
            <template v-if="posts.length">
              <div v-for="post in posts" :key="post.id" class="group bg-white rounded-xl shadow-sm hover:shadow-lg border border-neutral-100 p-5 transition-all duration-300 hover:-translate-y-1">
                <div class="flex items-start justify-between gap-4">
                  <div class="flex-1">
                    <h3 class="font-bold text-neutral-900 group-hover:text-primary-600 transition-colors">{{ post.title }}</h3>
                    <p class="text-sm text-neutral-600 mt-2 line-clamp-2">{{ post.excerpt || '' }}</p>
                  </div>
                  <div class="text-xs text-neutral-500 whitespace-nowrap">{{ new Date(post.created_at).toLocaleDateString('it-IT') }}</div>
                </div>
                <div class="mt-4 flex justify-end">
                  <Link :href="route('posts.show', post.id)" class="inline-flex items-center gap-1 text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">
                    Leggi
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </Link>
                </div>
              </div>
            </template>
            <template v-else>
              <div class="bg-neutral-50 rounded-xl border-2 border-dashed border-neutral-200 p-8 text-center">
                <svg class="w-12 h-12 mx-auto text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <p class="mt-3 text-sm text-neutral-500">Nessun articolo disponibile.</p>
              </div>
            </template>
          </div>
        </div>

        <!-- Products column -->
        <div>
          <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
              <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
            </div>
            <h2 class="text-3xl font-bold text-neutral-900">Prodotti in evidenza</h2>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <template v-if="products.length">
              <div v-for="product in products" :key="product.id" class="group bg-white rounded-xl shadow-sm hover:shadow-lg border border-neutral-100 p-5 flex flex-col justify-between transition-all duration-300 hover:-translate-y-1">
                <div>
                  <div class="font-bold text-neutral-900 group-hover:text-primary-600 transition-colors">{{ product.name }}</div>
                  <div class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-green-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ product.price ? (product.price + ' €') : 'Prezzo non disponibile' }}
                  </div>
                </div>
                <div class="mt-4 flex items-center justify-between pt-4 border-t border-neutral-100">
                  <div class="text-xs text-neutral-500">{{ new Date(product.created_at).toLocaleDateString('it-IT') }}</div>
                  <Link :href="route('dashboard')" class="inline-flex items-center gap-1 text-sm font-medium text-primary-600 hover:text-primary-700 transition-colors">
                    Visualizza
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                  </Link>
                </div>
              </div>
            </template>
            <template v-else>
              <div class="col-span-2 bg-neutral-50 rounded-xl border-2 border-dashed border-neutral-200 p-8 text-center">
                <svg class="w-12 h-12 mx-auto text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <p class="mt-3 text-sm text-neutral-500">Nessun prodotto disponibile.</p>
              </div>
            </template>
          </div>
        </div>
      </section>



      <!-- Features section -->
      <section>
        <div class="text-center mb-12">
          <h3 class="text-4xl font-bold text-neutral-900">Perché scegliere WA</h3>
          <p class="mt-4 text-lg text-neutral-600 max-w-2xl mx-auto">Tutti gli strumenti di cui hai bisogno per far crescere il tuo business online</p>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <div class="group relative rounded-2xl bg-white p-8 shadow-sm hover:shadow-xl border border-neutral-100 transition-all duration-300 hover:-translate-y-2">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h4 class="font-bold text-lg text-neutral-900 mb-2">Facile da usare</h4>
            <p class="text-sm text-neutral-600 leading-relaxed">Interfaccia pensata per essere immediata e intuitiva.</p>
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-500/10 to-transparent rounded-2xl -z-10"></div>
          </div>
          <div class="group relative rounded-2xl bg-white p-8 shadow-sm hover:shadow-xl border border-neutral-100 transition-all duration-300 hover:-translate-y-2">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
            <h4 class="font-bold text-lg text-neutral-900 mb-2">Velocità</h4>
            <p class="text-sm text-neutral-600 leading-relaxed">Vite + Tailwind per build veloci e SPA reattive.</p>
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-green-500/10 to-transparent rounded-2xl -z-10"></div>
          </div>
          <div class="group relative rounded-2xl bg-white p-8 shadow-sm hover:shadow-xl border border-neutral-100 transition-all duration-300 hover:-translate-y-2">
            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
            </div>
            <h4 class="font-bold text-lg text-neutral-900 mb-2">Sicuro</h4>
            <p class="text-sm text-neutral-600 leading-relaxed">Autenticazione, CSRF e best practice incluse.</p>
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-purple-500/10 to-transparent rounded-2xl -z-10"></div>
          </div>
          <div class="group relative rounded-2xl bg-white p-8 shadow-sm hover:shadow-xl border border-neutral-100 transition-all duration-300 hover:-translate-y-2">
            <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
              </svg>
            </div>
            <h4 class="font-bold text-lg text-neutral-900 mb-2">Estendibile</h4>
            <p class="text-sm text-neutral-600 leading-relaxed">Costruito su Laravel: pacchetti e scaling semplici.</p>
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-pink-500/10 to-transparent rounded-2xl -z-10"></div>
          </div>
        </div>
      </section>

      <footer class="mt-20 pt-8 border-t border-neutral-200">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
          <div class="flex items-center gap-2 text-sm text-neutral-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
            </svg>
            <span>Laravel v{{ laravelVersion }} • PHP v{{ phpVersion }}</span>
          </div>
          <div class="text-sm text-neutral-400">
            Made by WA Team
          </div>
        </div>
      </footer>
      </main>
    </div>
  </AuthenticatedLayout>
</template>
