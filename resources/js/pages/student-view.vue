<script setup>
import { useRoute } from "vue-router";
import StudentDetail from "@/views/pages/account-settings/StudentDetail.vue";
import AddStudentDetails from "@/views/pages/form-layouts/AddStudentDetails.vue";
import { onMounted } from "vue";
import { getStudentDetail } from "@/services/student-service";


const route = useRoute();
const activeTab = ref(route.params.tab);

const data = ref(null);

// tabs
const tabs = [
    {
        title: "Account",
        icon: "mdi-account-outline",
        tab: "account",
    },
];

const fetchStudentDetail = () => {
    const id = route.params.id;
    getStudentDetail(id)
        .then((res) => {
            const studentData = res.data.data;
            data.value = studentData;
            if (studentData.student) {
                activeTab.value = "student-detail";
                tabs.unshift({
                    title: "Student Detail",
                    icon: "mdi-account-outline",
                    tab: "student-detail",
                });

            }
        })
        .catch((err) => {
            console.log(err);
        });
};

onMounted(fetchStudentDetail);





</script>

<template>
    <div>
        <VTabs v-model="activeTab" show-arrows>
            <VTab v-for="item in tabs" :key="item.icon" :value="item.tab">
                <VIcon size="20" start :icon="item.icon" />
                {{ item.title }}
            </VTab>
        </VTabs>
        <VDivider />

        <VWindow v-model="activeTab" class="mt-5 disable-tab-transition">
            <!-- Account -->
            <VWindowItem value="account"  >
                <StudentDetail :data="data" />
            </VWindowItem>
            <VWindowItem value="student-detail">
                <AddStudentDetails readonly="true" :data="data" />
            </VWindowItem>
        </VWindow>
    </div>
</template>
