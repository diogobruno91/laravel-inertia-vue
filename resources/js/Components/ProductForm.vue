<script setup>
import { ref } from 'vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import { router } from '@inertiajs/vue3'
import { useToast } from "primevue/usetoast";

const toast = useToast();

const visible = ref(false);
const name = ref('');
const price = ref(0);
const category = ref('');

const openModal = () => {
  visible.value = true;
};

const saveProduct = () => {
  router.post('/products', {
    name: name.value,
    price: price.value,
    category: category.value,
  }, {
    onSuccess: () => {
      visible.value = false
      toast.add({
        severity: 'success',
        summary: 'Sucesso',
        detail: 'Produto criado com sucesso',
        life: 2000
      });
      setTimeout(() => {
        router.visit('/dashboard')        
      }, 2000);
    }
  })
};
</script>

<template>
  <Toast />
  <div>
    <Button label="Criar Produto" icon="pi pi-plus" @click="openModal" />

    <Dialog v-model:visible="visible" modal header="Novo Produto" :style="{ width: '30rem' }">

       <div class="flex flex-col gap-4">
          <div>
            <label for="name" class="block mb-1">Nome</label>
            <InputText id="name" v-model="name" class="w-full" />
          </div>
          <div>
            <label for="price" class="block mb-1">Preço</label>
            <InputNumber id="price" v-model="price" mode="currency" currency="BRL" locale="pt-BR" class="w-full" />
          </div>
          <div>
            <label for="category" class="block mb-1">Categoria</label>
            <InputText id="category" v-model="category" class="w-full" />
          </div>
        </div>

      <template #footer>
        <Button label="Cancelar" icon="pi pi-times" class="p-button-text" @click="visible = false" />
        <Button label="Salvar" icon="pi pi-check" @click="saveProduct" />
      </template>
    </Dialog>
  </div>
</template>

<style scoped>
.field {
  margin-bottom: 1rem;
}
</style>
