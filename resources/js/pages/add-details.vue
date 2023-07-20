<script setup>
import AddStudentDetails from "@/views/pages/form-layouts/AddStudentDetails.vue";
</script>

<template>
    <div>
        <VRow>
            <VCol cols="12">
                <!-- 👉 Multiple Column -->
                <VCard title="Add Student">
                    <VCardText>
                        <AddStudentDetails />
                    </VCardText>
                </VCard>
            </VCol>
        </VRow>
    </div>
</template>
