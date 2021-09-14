<template>
    <Dialog
        v-model:visible="productDialog"
        :style="{ width: '450px' }"
        header="Product Details"
        :modal="true"
        class="p-fluid"
    >
        <div class="p-field">
            <label for="name">Name</label>
            <InputText
                id="name"
                v-model.trim="product.name"
                required="true"
                autofocus
                :class="{ 'p-invalid': submitted && !product.name }"
            />
            <small class="p-error" v-if="submitted && !product.name"
                >Name is required.</small
            >
        </div>
        <div class="p-field">
            <label for="description">Description</label>
            <Textarea
                id="description"
                v-model="product.description"
                required="true"
                rows="3"
                cols="20"
            />
        </div>
        <template #footer>
            <Button
                label="Cancel"
                icon="pi pi-times"
                class="p-button-text"
                @click="hideDialog"
            />
            <Button
                label="Save"
                icon="pi pi-check"
                class="p-button-text"
                @click="saveProduct"
            />
        </template>
    </Dialog>
</template>
