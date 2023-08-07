<script setup>
import { onMounted } from "vue";
import { getUserCount } from "@/services/user-service";
import { getLocalAuth } from "@/utils/local";

const statistics = [
    {
        title: "Sales",
        stats: "245k",
        icon: "mdi-trending-up",
        color: "primary",
    },
    {
        title: "Customers",
        stats: "12.5k",
        icon: "mdi-account-outline",
        color: "success",
    },
    {
        title: "Product",
        stats: "1.54k",
        icon: "mdi-cellphone-link",
        color: "warning",
    },
    {
        title: "Revenue",
        stats: "$88k",
        icon: "mdi-currency-usd",
        color: "info",
    },
];

const userCount = ref({});
const localUser = JSON.parse(getLocalAuth());
const fetchData = async () => {
    try {
        const response = await getUserCount();
        userCount.value.overall_user = response?.data?.data?.overall_user;
        userCount.value.current_month = response?.data?.data?.current_month;
        userCount.value.previous_month = response?.data?.data?.previous_month;
    } catch (error) {
        console.error(error);
    }
};

onMounted(fetchData);
</script>

<template>
    <VCard>
        <VCardItem>
            <VCardTitle>Overall Users</VCardTitle>
        </VCardItem>

        <VCardText>
            <h6 class="text-sm font-weight-medium mb-12">
                <span
                    >Total
                    {{
                        (userCount.current_month - userCount.previous_month) /
                            userCount.previous_month !==
                        Infinity
                            ? (userCount.current_month -
                                  userCount.previous_month) /
                              userCount.previous_month
                            : "100%"
                    }}
                    Growth 😎</span
                >
                <span class="font-weight-regular"> this month</span>
            </h6>

            <VRow>
                <VCol
                    v-for="item in userCount.overall_user"
                    :key="item.role_id"
                    cols="6"
                    sm="3"
                >
                    <div class="d-flex align-center">
                        <div class="me-3">
                            <VAvatar
                                :color="item.color"
                                rounded
                                size="42"
                                class="elevation-1"
                            >
                                <VIcon
                                    size="24"
                                    v-if="item.role_id === 1"
                                    icon="mdi-account-cog"
                                />
                                <VIcon
                                    size="24"
                                    v-if="item.role_id === 2"
                                    icon="mdi-account-tie-outline"
                                />
                                <VIcon
                                    size="24"
                                    v-if="item.role_id === 3"
                                    icon="mdi-account-school"
                                />
                            </VAvatar>
                        </div>

                        <div class="d-flex flex-column">
                            <span class="text-caption">
                                {{
                                    item.role_id === 1
                                        ? "Admin"
                                        : item.role_id === 2
                                        ? "Counsellor"
                                        : "Student"
                                }}
                            </span>
                            <span class="text-h6">{{ item.count }}</span>
                        </div>
                    </div>
                </VCol>
            </VRow>
        </VCardText>
    </VCard>
</template>