<script setup>
import VueTableLite from "vue3-table-lite";
import SvgIcon from "vue3-icon";
import { faPen, faTrash } from "@fortawesome/free-solid-svg-icons";

import Modal from '@/Components/Modal.vue';
import ProductForm from '@/Components/ProductForm.vue';
import { useForm } from '@inertiajs/vue3';


import { ref, onMounted, reactive, watch } from 'vue';

const props = defineProps({
    refreshList: {
        type: Boolean,
        default: false,
    },
    widgetList: {
        type: Array,
        default: [],
    }
});

const emit = defineEmits(['refreshList', 'refreshProductCount'])
let showModal = ref(false)
let productId = ref(0)

// Init Your table settings
const table = reactive({
    isLoading: false,
    columns: [
    {
        label: "ID",
        field: "id",
        width: "3%",
        sortable: true,
        isKey: true,
    },
    {
        label: "Name",
        field: "name",
        width: "10%",
        sortable: true,
    },
    {
        label: "Summary",
        field: "summary",
        width: "20%",
        sortable: true,
    },
    {
        label: "Image",
        field: "image",
        width: "15%",
        sortable: true,
    },
    {
      label: "Actions",
      field: "action",
      width: "5%",
      sortable: false,
    },
    ],
    rows: [],
    totalRecordCount: 0,
    sortable: {
    order: "id",
    sort: "asc",
    },
});

const form = useForm({
    name: '',
    summary: '',
    image: {},
});

const getData = () => {
    axios.get('/get-products').then((res) => {
        if(res.status === 200){
            table.rows = res.data.map(el => {
                const {
                    id,
                    name,
                    summary,
                    image
                } = el
                return {
                    id,
                    name,
                    summary,
                    image
                }
            })
    
            emit('refreshList', false)
        }
    })
}

const edit = (data) => {
    showModal.value = true
    productId.value = data
}

const del = (data) => {
    console.log(data, 'delete')
}

const closeModal = () => {
    showModal.value = false;

    form.reset();
};

const updateRefresh = (data) => {
    showModal.value = false;
    if(data){
        getData()
    }
    form.reset();
};

const refProdCount = (data) => {
    emit('refreshProductCount', data)
};

onMounted(getData);

watch(
    () => props.refreshList,
    () => {
        if (props.refreshList) {
            getData();
        }
    }
);

</script>

<template>
    <div>
        <div class="table-wrapper">
            <VueTableLite
                :is-loading="table.isLoading"
                :columns="table.columns"
                :rows="table.rows"
                :total="table.totalRecordCount"
                :sortable="table.sortable"
                :is-hide-paging="true"
                :is-slot-mode="true"
                @do-search="doSearch"
                @is-finished="tableLoadingFinish"
            >
                <template v-slot:action="data">
                    <div style="display: flex; justify-content: space-evenly;">
                        <svg-icon class="clickable" :fa-icon="faPen" :size="18" flip="horizontal" @click="edit(data.value.id)" ></svg-icon>
                        <svg-icon class="clickable" :fa-icon="faTrash" :size="18" flip="horizontal" @click="del(data.value.id)" ></svg-icon>
                    </div>
                </template>
            </VueTableLite>

            <Modal :show="showModal" @close="closeModal">
                <div style="padding: 50px;">
                    <ProductForm :productId="productId" @refreshListFromUpdate="updateRefresh($event)" @refreshListProdCount="refProdCount($event)" :widgetList="widgetList"/>
                </div>
            </Modal>
        </div>
    </div>
</template>
<style>
    .table-wrapper{
        padding: 50px;
    }
    .clickable {
        cursor: pointer;
    }
</style>