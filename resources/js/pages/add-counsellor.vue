<script setup>
import CounsellorForm from "@/views/pages/form-layouts/CounsellorForm.vue";
</script>

<template>
    <div>
        <VRow>
            <VCol cols="12">
                <!-- 👉 Multiple Column -->
                <VCard title="Add Counsellor">
                    <VCardText>
                        <CounsellorForm />
                    </VCardText>
                </VCard>
            </VCol>
        </VRow>
    </div>
</template>
