<script setup>
import { ref } from 'vue';

const count = ref(0);

const increment = () => {
    count.value++
}
</script>

<template>
    <div>
        <h1>Hello World!</h1>
        <p>Current user: {{ $page.props.auth?.user?.name ?? 'No auth is active' }}</p>
        <p>{{ count }}</p>
        <button @click="increment" class="bg-green-900">Increment</button>
    </div>
</template>
