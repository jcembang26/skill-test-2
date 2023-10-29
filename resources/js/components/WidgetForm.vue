<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

import VueTableLite from "vue3-table-lite";

import { useForm } from '@inertiajs/vue3';
import axios from 'axios';

import { ref, onMounted, reactive } from 'vue';

const props = defineProps({
    id: {
        type: Number,
        default: 0,
    }
});

const emit = defineEmits('closeModal')

// Init Your table settings
const table = reactive({
    isLoading: false,
    columns: [
    // {
    //     label: "ID",
    //     field: "id",
    //     width: "50%",
    //     sortable: true,
    //     isKey: true,
    // },
    {
        label: "Label",
        field: "label",
        width: "50%",
        sortable: true,
    },
    {
        label: "Summary",
        field: "summary",
        width: "50%",
        sortable: true,
    }
    ],
    rows: [],
    totalRecordCount: 0,
    sortable: {
    order: "id",
    sort: "asc",
    },
});


const form = useForm({
    id: '',
    label: '',
    email: '',
    slot: 1,
    products: [],
});

let slots = ref([])

const getPageSlot = () => {
    axios.get('/get-slots').then(res => {
        if(res.status === 200){
            const data = res.data ?? []

            slots.value = data.map(el => {
                return { ...el }
            })
        }
    })
}

const getData = () => {
    axios.get('/get-widget-setting', {params: {
        id: props.id
    }}).then(res => {
        if(res.status === 200){
            const data = res.data ?? []
            
            const {
                id,
                label,
                email,
                page_slot_id,
                products
            } = data

            form.id = id
            form.label = label
            form.email = email
            form.slot = page_slot_id

            if(products && products.length > 0){

                table.products = products.map(el => {
                    return {...el, label: el.details ? el.details.name : '', summary: el.details ? el.details.summary : '' }
                })

                table.totalRecordCount = products.length
            }
        }
    })
}

async function save() {
    const res = await axios.post('/upsert-widget-setting', form)

    if(res.status === 200){
        emit('closeModal', true)
    }
}

onMounted(async () => {
    getPageSlot()
    getData()
})

</script>
<template>
    <div style="padding: 50px;">
        <form @submit.prevent class="space-y-6" style="padding: 50px;">
            <div>
                <InputLabel for="label" value="Label" />

                <TextInput
                    id="label"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.label"
                    required
                    autofocus
                    autocomplete="label"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="slot" value="Page Slots" />

                <div v-for="slot of slots">
                    <input type="radio" id="slot" name="slot" :value="slot.id" v-model="form.slot" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"/>
                    <label class="ml-2 text-sm text-gray-600" for="yes">{{ `${slot.name}` }}</label><br />
                </div>
            </div>

            <div>
                <VueTableLite
                    :is-loading="table.isLoading"
                    :columns="table.columns"
                    :rows="table.products"
                    :total="table.totalRecordCount"
                    :sortable="table.sortable"
                    :is-hide-paging="true"
                    @is-finished="tableLoadingFinish"
                >
                </VueTableLite>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton @click="save()" :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </div>
</template>