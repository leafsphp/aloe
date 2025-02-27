<script>
    const { title, description } = $props();
</script>

<template>
    <header>
        <h3 class="mb-0.5 text-base font-medium">{title}</h3>
        {#if description}
            <p class="text-sm text-muted-foreground">
                {description}
            </p>
        {/if}
    </header>
</template>
