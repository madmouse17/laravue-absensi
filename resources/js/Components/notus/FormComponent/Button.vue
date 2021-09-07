<template>
    <div class="w-full lg:w-6/12 px-4">
        <button
            class="
                bg-emerald-500
                text-white
                active:bg-emerald-600
                font-bold
                uppercase
                text-xs
                px-4
                py-2
                rounded
                shadow
                hover:shadow-md
                outline-none
                focus:outline-none
                mr-1
                ease-linear
                transition-all
                duration-150
            "
            type="submit"
        >
            {{ title }}
        </button>
    </div>
</template>
<script>
export default {
    props: ["title"],
};
</script>
