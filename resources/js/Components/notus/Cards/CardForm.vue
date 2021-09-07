<template>
    <div
        class="
            relative
            flex flex-col
            min-w-0
            break-words
            w-full
            mb-12
            shadow-lg
            rounded-lg
            bg-blueGray-100
            border-0
        "
    >
        <div class="rounded-t bg-white mb-0 px-6 py-6">
            <div class="text-center flex justify-between">
                <h6 class="text-blueGray-700 text-xl font-bold">
                    {{ titleHead }}
                </h6>
            </div>
        </div>
        <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
                {{ titleBottom }}
            </h6>
            <slot />
        </div>
    </div>
</template>
<script>
export default {
    props: ["titleHead", "titleBottom"],
};
</script>
