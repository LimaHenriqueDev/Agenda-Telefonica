<template>
    <div class="my-2">
        <div class="mb-1">
            <label :for="props.id" class="form-label">{{ props.label }}</label>
            <input
                :placeholder="props.placeholder"
                :id="props.id"
                :value="props.modelValue"
                @input="
                    (event) => emits('update:modelValue', event.target.value)
                "
                @blur="() => emits('blur')"
                class="form-control"
                :class="{
                    'is-invalid': props.error,
                }"
                :type="props.type"
            />
        </div>
        <span class="text-danger">{{ props.error }}</span>
    </div>
</template>
<script setup>
const props = defineProps({
    label: { type: String, required: false },
    id: { type: String, required: false },
    placeholder: { type: String, required: false },
    type: { type: String, required: false, default: "text" },
    error: { type: [String, null], required: false },
    modelValue: { type: [String, Number, null], required: false },
});

const emits = defineEmits(["update:modelValue", "blur"]);
</script>
