<script setup>
import { ref, defineProps, watch } from "vue";

const props = defineProps(["data"]); // Declare the props that the child component expects

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
                <th class="text-uppercase text-center">Date</th>
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
                <td class="text-center">
                    {{ item.created_at.slice(0, item.created_at.indexOf("T")) }}
                </td>
            </tr>
        </tbody>
    </VTable>
</template>
