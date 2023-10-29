<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

import Modal from '@/Components/Modal.vue';
import WidgetForm from '@/Components/WidgetForm.vue';

import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

let showModal = ref(false);
let widgets = ref([])
let widgetId = ref(0)

const closeModal = () => {
    showModal.value = false
}

function getWidgets () {
    axios.get('/get-widgets').then(res => {
        if(res.status === 200){
            const data = res.data ?? []

            widgets.value = data.map(el => {
                return {
                    ...el
                }
            })
        }
    })
}

function modal(id){
    showModal.value = true
    widgetId.value = id
}

onMounted(async () => {
    await getWidgets()
})

</script>
<template>

    <Head title="Widgets" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Widgets</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="padding: 50px;">
                    
                    <h2 v-for="widget of widgets" class="font-semibold text-xl text-gray-800 leading-tight hyperLink" @click="modal(widget.id)">{{ widget.name }}</h2>

                    <Modal :show="showModal" @close="closeModal" >
                        <WidgetForm :id="widgetId" @closeModal="closeModal"/>
                    </Modal>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>
.hyperLink {
    cursor: pointer;
}

.hyperLink:hover {
    text-decoration: underline !important;
}
</style>