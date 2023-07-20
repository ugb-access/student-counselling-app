<script setup>
import StudentForm from "@/views/pages/form-layouts/StudentForm.vue";
</script>

<template>
    <div>
        <VRow>
            <VCol cols="12">
                <!-- 👉 Multiple Column -->
                <VCard title="Add Student">
                    <VCardText>
                        <StudentForm />
                    </VCardText>
                </VCard>
            </VCol>
        </VRow>
    </div>
</template>
