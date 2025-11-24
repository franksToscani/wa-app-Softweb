<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <div class="flex min-h-screen flex-col items-center bg-neutral-50 pt-6 sm:justify-center sm:pt-0">
    <div class="mb-4">
      <Link href="/" class="inline-flex items-center gap-2">
        <ApplicationLogo class="h-12 w-auto" />
        <span class="text-2xl font-semibold text-primary-700">WA App</span>
      </Link>
    </div>

    <div class="mt-6 w-full overflow-hidden bg-white px-6 py-6 shadow-md sm:max-w-md sm:rounded-lg">
      <slot />
    </div>
  </div>
</template>
