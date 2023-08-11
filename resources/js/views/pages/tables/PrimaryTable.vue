<script setup>
import { ref, defineProps, watch } from "vue";

const props = defineProps(["data", "tableType"]); // Declare the props that the child component expects

const storedData = ref([]);

// Watch for changes in the data prop and update the storedData variable
watch(
    () => props.data,
    (newData) => {
        storedData.value = newData;
    }
);
</script>

<template>
    <VTable fixed-header>
        <thead>
            <tr>
                <th class="text-uppercase">#</th>
                <th class="text-uppercase">Name</th>
                <th class="text-uppercase text-center">Username</th>
                <th class="text-uppercase text-center">Email</th>
                <th
                    v-if="tableType !== 'admin'"
                    class="text-uppercase text-center"
                >
                    Phone Number
                </th>
                <th
                    v-if="tableType !== 'counsellor' && tableType !== 'admin'"
                    class="text-uppercase text-center"
                >
                    Status
                </th>
                <th class="text-uppercase text-center">Date</th>

                <th
                    v-if="tableType !== 'admin'"
                    class="text-uppercase text-center"
                >
                    Action
                </th>
            </tr>
        </thead>

        <tbody>
            <tr v-for="(item, index) in storedData" :key="item.id">
                <td>
                    {{ index + 1 }}
                </td>
                <td>
                    {{ item.name }}
                </td>
                <td class="text-center">
                    {{ item.username }}
                </td>
                <td class="text-center">
                    {{ item.email }}
                </td>
                <td v-if="tableType !== 'admin'" class="text-center">
                    {{ item.phone_number }}
                </td>
                <td
                    v-if="tableType !== 'counsellor' && tableType !== 'admin'"
                    class="text-center"
                >
                    {{
                        item.student?.full_name
                            ? !item.student?.cv_path ||
                              !item.student?.passport ||
                              !item.student?.academic_document ||
                              !item.student?.teacher_reference ||
                              !item.student?.cnic ||
                              !item.student?.experience_letter ||
                              !item.student?.other_certificates ||
                              !item.student?.conditional_offer ||
                              !item.student?.unconditional_offer ||
                              !item.student?.payment_proof ||
                              !item.student?.cas_ecoe ||
                              !item.student?.visa ||
                              !item.student?.travel_plan ||
                              !item.student?.gt_document ||
                              (!item.student?.english_test?.moi &&
                                  !item.student?.english_test?.english_proficiency &&
                                  !item.student?.english_test?.ielts &&
                                  !item.student?.english_test?.other_english_test)
                                ? "Incomplete"
                                : "Completed"
                            : "Incomplete"
                    }}
                </td>
                <td class="text-center">
                    {{ item.created_at.slice(0, item.created_at.indexOf("T")) }}
                </td>

                <td v-if="tableType !== 'admin'" class="text-center">
                    <Component
                        is="a"
                        :href="`${
                            tableType === 'counsellor'
                                ? '/counsellors'
                                : '/student'
                        }/view/${item.id}`"
                    >
                        <VBtn
                            color="primary"
                            text
                            @click="handleActionClick"
                            class="action-button mr-1 py-1"
                            size="small"
                            icon="mdi-eye"
                        >
                        </VBtn>
                    </Component>
                    <Component
                        is="a"
                        :href="`${
                            tableType === 'counsellor'
                                ? '/counsellors'
                                : '/student'
                        }/edit/${item.id}`"
                    >
                        <VBtn
                            color="primary"
                            text
                            @click="handleActionClick"
                            class="action-button py-1"
                            size="small"
                            icon="mdi-pencil"
                        ></VBtn
                    ></Component>
                </td>
            </tr>
        </tbody>
    </VTable>
</template>
