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
                <th
                    v-if="tableType !== 'counsellor' && tableType !== 'admin'"
                    class="text-uppercase text-center"
                >
                    Payment Status
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
                    {{ item.email }}
                </td>
                <td v-if="tableType !== 'admin'" class="text-center">
                    {{ item.phone_number }}
                </td>
                <td
                    v-if="tableType !== 'counsellor' && tableType !== 'admin'"
                    class="text-center"
                >
                    <span class="text-error" v-if="!item.student?.status"
                        >Incomplete</span
                    >
                    <span class="text-success" v-else>Complete</span>
                </td>
                <td
                    v-if="tableType !== 'counsellor' && tableType !== 'admin'"
                    class="text-center"
                >
                    <span
                        class="text-error"
                        v-if="!item.student?.payment_status"
                        >Not Received</span
                    >
                    <span class="text-success" v-else>Received</span>
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
