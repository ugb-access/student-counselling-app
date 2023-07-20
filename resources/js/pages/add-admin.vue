<script setup>
import AdminForm from "@/views/pages/form-layouts/AdminForm.vue";
</script>

<template>
    <div>
        <VRow>
            <VCol cols="12">
                <!-- 👉 Multiple Column -->
                <VCard title="Add Admin">
                    <VCardText>
                        <AdminForm />
                    </VCardText>
                </VCard>
            </VCol>
        </VRow>
    </div>
</template>
