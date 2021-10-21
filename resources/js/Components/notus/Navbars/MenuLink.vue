<template>
    <Link :href="href" :class="menu">
        <slot />
    </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    components: {
        Link,
    },

    props: ["href", "active"],

    computed: {
        menu() {
            return this.active
                ? "bg-gray-900 text-white"
                : " text-gray-300 hover:bg-gray-700 hover:text-white";
        },
    },
};
</script>
