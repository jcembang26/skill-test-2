<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import ProductForm from '@/Components/ProductForm.vue';
import ProductList from '@/Components/ProductList.vue';
import { Head } from '@inertiajs/vue3';

import { ref } from "vue";

let refresh = ref(false)
let refProdCount = ref(false)

const updateRefresh = (data) => {
    refresh.value = data
}

const refProductCount = (data) => {
    refProdCount.value = data
}

</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div style="padding: 50px 50px 0 50px">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Store</h2>
                    </div>
                    <ProductForm @refreshListFromStore="updateRefresh($event)" :refreshProdCount="refProdCount"/>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 20px;">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div style="padding: 50px 50px 0 50px">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight">List</h2>
                    </div>
                    <ProductList :refreshList="refresh" @refreshList="updateRefresh($event)" @refreshProductCount="refProductCount($event)" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>