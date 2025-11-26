<script setup>
import { Head, Link } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'

const props = defineProps({
  canLogin: { type: Boolean, default: false },
  canRegister: { type: Boolean, default: false },
  isAdmin: { type: Boolean, default: false },
  posts: { type: Array, default: () => [] },
  products: { type: Array, default: () => [] },
})
</script>

<template>
  <Head title="Home" />
  <div class="min-h-screen bg-gradient-to-b from-white via-neutral-50 to-neutral-100">
    <header class="mx-auto max-w-7xl px-6 py-8 flex items-center justify-between">
      <Link href="/" class="inline-flex items-center gap-3">
        <ApplicationLogo class="h-12 w-auto" />
        <span class="text-xl font-semibold text-primary-700">WA App</span>
      </Link>

      

      <nav class="flex items-center gap-3">
        <Link href="/" class="text-sm text-neutral-700 hover:text-neutral-900">Welcome</Link>
        <Link v-if="$page.props.auth.user && isAdmin" :href="route('dashboard')" class="text-sm text-neutral-700 hover:text-neutral-900">Dashboard</Link>

        <!-- Authenticated user: show profile dropdown -->
        <div v-if="$page.props.auth.user" class="hidden sm:ms-6 sm:flex sm:items-center">
          <div class="relative ms-3">
            <Dropdown align="right" width="48">
              <template #trigger>
                <span class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                  >
                    {{ $page.props.auth.user.username }}

                    <svg
                      class="-me-0.5 ms-2 h-4 w-4"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
                <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
              </template>
            </Dropdown>
          </div>
        </div>

        <!-- Guest: show login/register -->
        <div v-else class="flex items-center gap-3">
          <Link v-if="canLogin" :href="route('login')" class="text-sm text-neutral-700 hover:text-neutral-900">Log in</Link>
          <Link v-if="canRegister" :href="route('register')" class="ml-3">
            <PrimaryButton>Get started</PrimaryButton>
          </Link>
        </div>
      </nav>
    </header>

    <main class="mx-auto w-full max-w-7xl px-6 py-16">
      <!-- Hero -->
      <section class="bg-white rounded-lg shadow-sm p-8 mb-12">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
          <div class="lg:flex-1">
            <h1 class="text-4xl font-extrabold text-neutral-900">Il tuo negozio online con WA</h1>
            <p class="mt-4 text-lg text-neutral-700 max-w-2xl">Vendi i tuoi prodotti, pubblica contenuti e gestisci gli ordini con una piattaforma semplice e scalabile.</p>

            <div class="mt-6 flex items-center gap-4">
              <Link v-if="!$page.props.auth.user && canRegister" :href="route('register')">
                <PrimaryButton>Inizia ora</PrimaryButton>
              </Link>
              <Link v-if="!$page.props.auth.user && canLogin" :href="route('login')" class="text-sm text-neutral-700 hover:text-neutral-900">Oppure accedi</Link>
              <Link v-if="$page.props.auth.user && isAdmin" :href="route('dashboard')" class="ml-4">
                <PrimaryButton>Apri pannello admin</PrimaryButton>
              </Link>
            </div>
          </div>

          <div class="lg:w-1/3">
            <img src="/images/hero-illustration.svg" alt="hero" class="w-full h-auto rounded-lg shadow" />
          </div>
        </div>
      </section>

      <!-- Side-by-side lists: posts (left) and products (right) -->
      <section class="grid gap-8 lg:grid-cols-2">
        <!-- Posts column -->
        <div>
          <h2 class="text-2xl font-semibold text-neutral-900 mb-4">Ultimi articoli</h2>
          <div class="grid gap-4">
            <template v-if="posts.length">
              <div v-for="post in posts" :key="post.id" class="bg-white rounded-lg shadow p-4">
                <div class="flex items-start justify-between">
                  <div>
                    <h3 class="font-semibold text-neutral-900">{{ post.title }}</h3>
                    <p class="text-sm text-neutral-600 mt-2">{{ post.excerpt || '' }}</p>
                  </div>
                  <div class="text-sm text-neutral-500">{{ new Date(post.created_at).toLocaleDateString() }}</div>
                </div>
                <div class="mt-3 flex justify-end">
                  <Link :href="route('dashboard')" class="text-sm text-primary-600 hover:underline">Leggi</Link>
                </div>
              </div>
            </template>
            <template v-else>
              <div class="text-sm text-neutral-500">Nessun articolo disponibile.</div>
            </template>
          </div>
        </div>

        <!-- Products column -->
        <div>
          <h2 class="text-2xl font-semibold text-neutral-900 mb-4">Prodotti in evidenza</h2>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <template v-if="products.length">
              <div v-for="product in products" :key="product.id" class="bg-white rounded-lg shadow p-4 flex flex-col justify-between">
                <div>
                  <div class="font-semibold text-neutral-900">{{ product.name }}</div>
                  <div class="text-sm text-neutral-600 mt-2">Prezzo: {{ product.price ? (product.price + ' €') : '—' }}</div>
                </div>
                <div class="mt-4 flex items-center justify-between">
                  <div class="text-sm text-neutral-500">{{ new Date(product.created_at).toLocaleDateString() }}</div>
                  <Link :href="route('dashboard')" class="text-sm text-primary-600 hover:underline">Visualizza</Link>
                </div>
              </div>
            </template>
            <template v-else>
              <div class="text-sm text-neutral-500">Nessun prodotto disponibile.</div>
            </template>
          </div>
        </div>
      </section>

      <footer class="mt-16 text-center text-sm text-neutral-500">
        © WA App
      </footer>
    </main>
  </div>
</template>
