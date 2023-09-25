<script setup>
import triangleDark from "@images/misc/triangle-dark.png";
import triangleLight from "@images/misc/triangle-light.png";
import avatar from "@images/avatars/avatar-10.png";
import AnalyticsAdmin from "@/views/dashboard/AnalyticsAdmin.vue";
import AnalyticsAward from "@/views/dashboard/AnalyticsAward.vue";
import AnalyticsStudentCounsellor from "@/views/dashboard/AnalyticsStudentCounsellor.vue";
import UserAnalytics from "@/views/dashboard/UserAnalytics.vue";

import AnalyticsNotification from "@/views/dashboard/AnalyticsNotification.vue";
import { getLocalAuth } from "@/utils/local";

import StudentDashboard from "@/views/dashboard/StudentDashboard.vue";

const localUser = JSON.parse(getLocalAuth());
</script>

<template>
    <VRow class="match-height">
        <VCol
            cols="12"
            md="8"
            v-if="localUser.data.role_id === 1 || localUser.data.role_id === 2"
        >
            <UserAnalytics />
        </VCol>
        <VCol cols="12" md="4">
            <VCard>
                <VCardItem>
                    <VCardTitle>Welcome Back !</VCardTitle>
                </VCardItem>

                <VCardText>
                    <h6 class="text-sm font-weight-medium mb-12">
                        {{ localUser?.data?.name }}
                    </h6>
                </VCardText>
                <!-- <div class="pt-2">
                    <VImg
                        :src="triangleLight"
                        class="triangle-bg flip-in-rtl"
                    />
                    <VImg :src="avatar" class="triangle-bg flip-in-rtl h-75 " />
                </div> -->
            </VCard>
        </VCol>

        <VCol
            cols="12"
            md="8"
            v-if="localUser.data.role_id === 1 || localUser.data.role_id === 2"
        >
            <AnalyticsStudentCounsellor />
        </VCol>

        <VCol cols="12" v-if="localUser.data.role_id === 3">
            <StudentDashboard readonly="true" type="student" />
        </VCol>
    </VRow>
</template>
