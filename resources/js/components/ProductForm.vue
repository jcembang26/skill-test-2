<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

import widgets from '@/database/widgets.js'

import { useForm } from '@inertiajs/vue3';
import axios from 'axios';

import { ref, watch, onMounted, computed } from 'vue';

const props = defineProps({
    refreshList: {
        type: Boolean,
        default: false,
    },
    refreshProdCount: {
        type: Boolean,
        default: false,
    },
    productId: {
        type: Number,
        default: 0,
    },
});

const emit = defineEmits(['refreshList', 'refreshListProdCount'])

let storedImg = ref('');
let productWidgetCount = ref(0);

const form = useForm({
    id: 0,
    name: '',
    summary: '',
    image: {},
    pod: 0, // product of the day
});

async function save() {
    const config = {
        headers: {
            'content-type': 'multipart/form-data'
        }
    }

    form.id = props.productId

  const res = await axios.post('/upsert', form, config)

  if(res.status === 200){

    if(form.id === 0){
        // reset form
        form.reset()
        countWidgetProduct()
        document.getElementById('inputTypeFile').value = '';
        emit('refreshListFromStore', true)
    }
    
    emit('refreshListProdCount', true)
    emit('refreshListFromUpdate', true)
  }
}

async function getData() {
    if(props.productId === 0) return false;
    
    axios.get(`/edit-product/${props.productId}`).then((res) => {
        if(res.status === 200){
            if(res.data.length === 0) return false

            const {
                id,
                name,
                summary,
                image,
                widget
            } = res.data
            
            form.id = id
            form.name = name
            form.summary = summary
            form.pod = widget ? 1 : 0
            storedImg.value = image
        }
    })

}

function changeImage(event){
    form.image = event.target.files[0];
}

function subtractCount(){
    let currVal = productWidgetCount.value
    productWidgetCount.value = form.pod ? currVal - 1 : currVal + 1 ;
}

function countWidgetProduct() {
    axios.get('count-widget-product').then(res => {
        if(res.status === 200){
            const storedCount = res.data ?? 0
    
            productWidgetCount.value =  5 - storedCount
        }
    })
    
    emit('refreshListProdCount', false)
}

onMounted(async () => {
    getData();
    countWidgetProduct();
})

watch(
    () => props.productId,
    () => {
        if (props.productId > 0) {
            getData();
        }
    }
);

watch(
    () => props.refreshProdCount,
    () => {
        if (props.refreshProdCount) {
            countWidgetProduct()
        }
    }
);

const isChckbxDisable = computed(() => {
    if(form.id > 0){
        return !productWidgetCount.value && !form.pod
    }else{
        return !productWidgetCount.value
    }
})
</script>

<template>
    <div>
        <form @submit.prevent class="space-y-6" style="padding: 50px;">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="summary" value="Summary" />

                <textarea
                id="summary"
                class="border-gray-300 w-100 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                row="10"
                v-model="form.summary"
                style="width: 100%;"
                >
                </textarea>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <img v-if="props.productId > 0 && storedImg && storedImg.length > 0" :src="storedImg" :alt="form.name">
            </div>

            <div>
                <InputLabel for="image" value="Image" />

                <input id="inputTypeFile" type="file" v-on:change="changeImage"/>

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="widgets" value="Widgets" />
                
                <div v-for="widget of widgets">
                    <input
                        :disabled="isChckbxDisable"
                        type="checkbox"
                        v-model="form.pod"
                        :true-value="1"
                        :false-value="0"
                        @change="subtractCount()"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    />
                    <span class="ml-2 text-sm text-gray-600">{{ `${widget.name} (${productWidgetCount})` }}</span>
                </div>

                <InputError class="mt-2" :message="form.errors.name" />
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