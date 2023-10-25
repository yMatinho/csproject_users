<template>
    <div :class="'col-md-' + col_size">
        <div :class="'form-group ' + (errors != null ? 'has-error' : '')">
            <label>{{ field_label }}:</label>
            <select :name="field_id" class="form-control select2" required :data-selected-id="field_value"
                tabindex="1">      
                <option disabled value="0">Selecione uma opção</option>
                <option v-for="option in options" :value="option.value">{{option.label}}</option>
            </select>
            <div class="msg-validate">
                <label v-for="error in errors" id="text-error" class="error" :for="field_id">{{ error }}</label>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['field_id', 'field_label', 'field_value', 'errors', 'col_size', 'options']
}
</script>