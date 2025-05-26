<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, ref } from "vue";
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ProductForm from '@/Components/ProductForm.vue';
import EditProductModal from '@/Components/EditProductModal.vue'
import Button from 'primevue/button';
import { router } from '@inertiajs/vue3';
import Toast from 'primevue/toast';

import { useToast } from "primevue/usetoast";

const toast = useToast();


const props = defineProps({
    products: Array
});

const products = ref(props.products.data);

const selectedProduct = ref(null)
const editModalVisible = ref(false)

const editProduct = (product) => {
  selectedProduct.value = product
  editModalVisible.value = true
}

const deleteProduct = (id) => {
  if (confirm('Tem certeza que deseja excluir este produto?')) {
    router.delete(`/products/${id}`, {
      onSuccess: () => {
        toast.add({
          severity: 'success',
          summary: 'Sucesso',
          detail: 'Produto excluido com sucesso',
          life: 2000
        })
        setTimeout(() => {
            router.visit('/dashboard')        
        }, 2000);
      }
    })
  }
}

</script>

<template>
    <Toast />
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
            <div class="flex justify-end">
                <ProductForm />
            </div>
        </template>
        <template #default>
            <div class="card">
                <DataTable :value="products" paginator :rows="5">
                    <Column field="name" header="Nome" />
                    <Column field="price" header="Preço" />
                    <Column field="category" header="Categoria" />
                    <Column header="Ações">
                        <template #body="slotProps">
                            <div class="flex gap-2">
                            <Button icon="pi pi-pencil" severity="warning" @click="editProduct(slotProps.data)" />
                            <Button icon="pi pi-trash" severity="danger" @click="deleteProduct(slotProps.data.id)" />
                            </div>
                        </template>
                    </Column />
                </DataTable>
                <EditProductModal v-model="editModalVisible":product="selectedProduct"/>
            </div>
        </template>
    </AuthenticatedLayout>
</template>
