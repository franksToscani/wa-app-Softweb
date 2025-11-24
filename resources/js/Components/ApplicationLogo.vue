<script setup>
const props = defineProps({
  src: { type: String, default: '/images/logo.svg' },
  alt: { type: String, default: 'WA logo' },
});
</script>

<template>
  <!-- Bind any classes/attributes passed from parent with $attrs -->
  <img :src="props.src" :alt="props.alt" v-bind="$attrs" class="h-10 w-auto" />
</template>
