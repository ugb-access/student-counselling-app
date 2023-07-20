<script setup>
import { getAllAdmins } from "@/services/user-service";
import { onMounted } from "vue";
import { getLocalAuth } from "@/utils/local";

const admins = ref([]);

const fetchData = async () => {
    const localUser = JSON.parse(getLocalAuth());
    if (localUser.data.role_id == 1) {
        try {
            const response = await getAllAdmins({ limit: 5 });
            admins.value = response.data.data;
        } catch (error) {
            console.error(error);
        }
    }
};

onMounted(fetchData);
</script>

<template>
    <VCard>
        <VCardItem>
            <VCardTitle>Admins</VCardTitle>

            <template #append>
                <a href="/admins" class="text-sm font-weight-medium"
                    >View All</a
                >
            </template>
        </VCardItem>

        <VCardText>
            <VList class="card-list">
                <VListItem v-for="admin in admins" :key="admin.id">
                    <VListItemTitle class="mb-1">
                        <span class="text-sm font-weight-medium">{{
                            admin.name
                        }}</span>
                    </VListItemTitle>

                    <VListItemSubtitle class="text-xs">
                        {{ admin.email }}
                    </VListItemSubtitle>
                </VListItem>
            </VList>
        </VCardText>
    </VCard>
</template>

<style lang="scss" scoped>
.card-list {
    --v-card-list-gap: 1.5rem;
}
</style>
