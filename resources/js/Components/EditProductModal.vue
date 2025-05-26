<script setup>
import { ref, watch, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'

import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import { useToast } from "primevue/usetoast";

const toast = useToast();

const props = defineProps({
  product: Object,
  modelValue: Boolean,
})

const emit = defineEmits(['update:modelValue'])

const visible = ref(props.modelValue)
watch(() => props.modelValue, val => (visible.value = val))
watch(visible, val => emit('update:modelValue', val))

const form = ref({ ...props.product })

watch(() => props.product, (newProduct) => {
  form.value = { ...newProduct }
}, { immediate: true })

const updateProduct = () => {
  router.put(`/products/${form.value.id}`, form.value, {
    onSuccess: () => {
      visible.value = false
      toast.add({
        severity: 'success',
        summary: 'Sucesso',
        detail: 'Produto atualizado com sucesso',
        life: 2000
      });
      setTimeout(() => {
        router.visit('/dashboard')        
      }, 2000);
    },
  })
}

</script>

<template>
  <Toast />
  <Dialog v-model:visible="visible" modal header="Editar Produto" :style="{ width: '400px' }">
    <div class="flex flex-col gap-4">
      <InputText v-model="form.name" placeholder="Nome" />
      <InputText v-model="form.price" placeholder="Preço" />
      <InputText v-model="form.category" placeholder="Categoria" />
    </div>

    <template #footer>
      <Button label="Cancelar" @click="visible = false" class="p-button-text" />
      <Button label="Salvar" @click="updateProduct" />
    </template>
  </Dialog>
</template>