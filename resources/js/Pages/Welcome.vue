<script setup>
import { Head, Link } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: { type: String, required: true },
  phpVersion: { type: String, required: true }
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
        <Link href="/" class="text-sm text-neutral-700 hover:text-neutral-900">Home</Link>
        <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="text-sm text-neutral-700 hover:text-neutral-900">Dashboard</Link>
        <template v-else>
          <Link v-if="canLogin" :href="route('login')" class="text-sm text-neutral-700 hover:text-neutral-900">Log in</Link>
          <Link v-if="canRegister" :href="route('register')" class="ml-3">
            <PrimaryButton>Get started</PrimaryButton>
          </Link>
        </template>
      </nav>
    </header>

    <main class="mx-auto w-full max-w-7xl px-6 py-16">
      <section class="grid gap-10 lg:grid-cols-2 lg:items-center">
        <div>
          <h1 class="text-4xl font-extrabold leading-tight text-neutral-900 sm:text-5xl">Crea, vendi e condividi con WA</h1>
          <p class="mt-6 max-w-xl text-lg text-neutral-700">Una piattaforma semplice e potente per gestire prodotti, post e ordini. Design pulito, performance eccellenti e tutti gli strumenti che ti servono per partire subito.</p>

          <div class="mt-8 flex items-center gap-4">
            <Link v-if="canRegister" :href="route('register')">
              <PrimaryButton>Inizia ora — è gratis</PrimaryButton>
            </Link>
            <Link v-if="canLogin" :href="route('login')" class="text-sm text-neutral-700 hover:text-neutral-900">Oppure accedi</Link>
          </div>

          <div class="mt-10 grid grid-cols-2 gap-4 sm:grid-cols-4">
            <div class="flex flex-col items-start">
              <strong class="text-lg font-semibold text-neutral-900">Prodotti</strong>
              <span class="text-sm text-neutral-600">Gestisci cataloghi e stock</span>
            </div>
            <div class="flex flex-col items-start">
              <strong class="text-lg font-semibold text-neutral-900">Ordini</strong>
              <span class="text-sm text-neutral-600">Traccia e processa vendite</span>
            </div>
            <div class="flex flex-col items-start">
              <strong class="text-lg font-semibold text-neutral-900">Media</strong>
              <span class="text-sm text-neutral-600">Carica immagini e video velocemente</span>
            </div>
            <div class="flex flex-col items-start">
              <strong class="text-lg font-semibold text-neutral-900">Sicurezza</strong>
              <span class="text-sm text-neutral-600">Autenticazione e permessi integrati</span>
            </div>
          </div>
        </div>

        <div class="order-first lg:order-last">
          <div class="rounded-2xl bg-gradient-to-br from-primary-600 to-primary-500 p-1 shadow-lg">
            <div class="rounded-2xl bg-white p-6 lg:p-8">
              <img src="/images/logo.svg" alt="WA logo" class="mx-auto h-28 w-28" />
              <p class="mt-6 text-center text-neutral-700">Interfaccia pulita e intuitiva — prova a registrarti per vedere la demo del pannello amministrativo.</p>
              <div class="mt-6 flex justify-center">
                <Link v-if="canRegister" :href="route('register')">
                  <PrimaryButton>Prova la demo</PrimaryButton>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="mt-16">
        <h3 class="text-xl font-semibold text-neutral-900">Perché scegliere WA</h3>
        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
          <div class="rounded-lg bg-white p-6 shadow-sm">
            <h4 class="font-semibold">Facile da usare</h4>
            <p class="mt-2 text-sm text-neutral-600">Interfaccia pensata per essere immediata.</p>
          </div>
          <div class="rounded-lg bg-white p-6 shadow-sm">
            <h4 class="font-semibold">Velocità</h4>
            <p class="mt-2 text-sm text-neutral-600">Vite + Tailwind per build veloci e SPA reattive.</p>
          </div>
          <div class="rounded-lg bg-white p-6 shadow-sm">
            <h4 class="font-semibold">Sicuro</h4>
            <p class="mt-2 text-sm text-neutral-600">Autenticazione, CSRF e best practice incluse.</p>
          </div>
          <div class="rounded-lg bg-white p-6 shadow-sm">
            <h4 class="font-semibold">Estendibile</h4>
            <p class="mt-2 text-sm text-neutral-600">Costruito su Laravel: pacchetti e scaling semplici.</p>
          </div>
        </div>
      </section>

      <footer class="mt-16 text-center text-sm text-neutral-500">
        Laravel v{{ laravelVersion }} • PHP v{{ phpVersion }}
      </footer>
    </main>
  </div>
</template>
