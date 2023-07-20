<script setup>
import { getAllCounsellor, getAllStudents } from "@/services/user-service";
import { getLocalAuth } from "@/utils/local";
import americanBank from "@images/logos/american-bank.png";
import aws from "@images/logos/aws.png";
import citiBank from "@images/logos/citi-bank.png";
import digitalOcean from "@images/logos/digital-ocean.png";
import github from "@images/logos/github.png";
import google from "@images/logos/google.png";
import gumroad from "@images/logos/gumroad.png";
import mastercardLabel from "@images/logos/mastercard-label.png";
import slack from "@images/logos/slack.png";
import stripe from "@images/logos/stripe.png";
import { onMounted } from "vue";
const students = ref([]);

const counsellors = ref([]);

const fetchData = async () => {
    try {
        const localUser = JSON.parse(getLocalAuth());
        if (localUser.data.role_id == 2) {
            const response = await getAllStudents({ limit: 5 });
            students.value = response?.data?.data;
        } else if (localUser.data.role_id == 1) {
            const response = await Promise.all([
                getAllStudents({ limit: 5 }),
                getAllCounsellor({ limit: 5 }),
            ]);
            students.value = response[0]?.data?.data;
            counsellors.value = response[1]?.data?.data;
        }
    } catch (error) {
        console.error(error);
    }
};

onMounted(fetchData);
</script>

<template>
    <VCard>
        <VRow no-gutters>
            <VCol cols="12" :md="counsellors.length > 0 ? 6 : 12">
                <VCardItem>
                    <VCardTitle>Student</VCardTitle>

                    <template #append>
                        <a href="/students" class="text-sm font-weight-medium"
                            >View All</a
                        >
                    </template>
                </VCardItem>

                <VCardText>
                    <VList class="card-list">
                        <VListItem
                            v-for="student in students"
                            :key="student.id"
                        >
                            <template #prepend>
                                <VAvatar start rounded>
                                    <VIcon
                                        size="24"
                                        icon="mdi-account-school"
                                    />
                                </VAvatar>
                            </template>

                            <VListItemTitle
                                class="text-sm font-weight-medium mb-1"
                            >
                                {{ student.name }}
                            </VListItemTitle>
                            <VListItemSubtitle class="text-xs">
                                {{ student.email }}
                            </VListItemSubtitle>

                            <template #append>
                                <VListItemAction
                                    class="text-success font-weight-medium"
                                >
                                    {{ student.phone_number }}
                                </VListItemAction>
                            </template>
                        </VListItem>
                    </VList>
                </VCardText>
            </VCol>

            <template v-if="counsellors.length > 0">
                <VDivider
                    :vertical="$vuetify.display.mdAndUp"
                    :inset="$vuetify.display.mdAndUp"
                />

                <VCol cols="12" md="6">
                    <VCardItem>
                        <VCardTitle>Counsellor</VCardTitle>

                        <template #append>
                            <a
                                href="/counsellors"
                                class="text-sm font-weight-medium"
                                >View All</a
                            >
                        </template>
                    </VCardItem>

                    <VCardText>
                        <VList class="card-list">
                            <VListItem
                                v-for="counsellor in counsellors"
                                :key="counsellor.id"
                            >
                                <template #prepend>
                                    <VAvatar start rounded>
                                        <VImg
                                            :height="29"
                                            :width="28"
                                            :src="gumroad"
                                        />
                                    </VAvatar>
                                </template>

                                <VListItemTitle
                                    class="text-sm font-weight-medium mb-1"
                                >
                                    {{ counsellor.name }}
                                </VListItemTitle>
                                <VListItemSubtitle class="text-xs">
                                    {{ counsellor.email }}
                                </VListItemSubtitle>

                                <template #append>
                                    <VListItemAction
                                        class="text-success font-weight-medium"
                                    >
                                        {{ counsellor.phone_number }}
                                    </VListItemAction>
                                </template>
                            </VListItem>
                        </VList>
                    </VCardText>
                </VCol>
            </template>
        </VRow>
    </VCard>
</template>

<style lang="scss" scoped>
.card-list {
    --v-card-list-gap: 1.5rem;
}
</style>
