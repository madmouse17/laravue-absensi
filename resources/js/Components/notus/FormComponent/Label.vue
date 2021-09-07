<template>
    <div class="w-full lg:w-6/12 px-4">
        <div class="relative w-full mb-3">
            <label
                class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                htmlFor="grid-password"
            >
                {{ title }}
            </label>
            <slot />
        </div>
    </div>
</template>
<script>
export default {
    props: ["title"],
};
</script>
