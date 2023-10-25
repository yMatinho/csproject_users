<template>
    <div v-if="type == 'text'" :class="'col-md-' + col_size">
        <div :class="'form-group ' + (errors != null ? 'has-error' : '')">
            <label>{{ field_label }}:</label>
            <input type="text" :name="field_id" class="form-control" :value="field_value" required>
            
        </div>
    </div>
    <div v-else-if="type == 'hidden'">
        <input type="hidden" :name="field_id" :value="field_value">
    </div>
    <div v-else-if="type == 'image'" :class="'col-md-' + col_size">
        <div :class="'form-group ' + (errors != null ? 'has-error' : '')">
            <label>{{ field_label }}:</label>
            <div class="input-file input-file-image">
                <img :src="field_value" class="img-upload-preview " :width="preview_size" src="" alt="preview">
                <input type="file" class="form-control form-control-file" :id="field_id" :name="field_id" accept="image/*"
                    required tabindex="4">

                <label :for="field_id" class=" label-input-file btn btn-primary">Upload de imagem</label>
            </div>
            
        </div>
    </div>
    <div v-else-if="type == 'file'" :class="'col-md-' + col_size">
        <div :class="'form-group ' + (errors != null ? 'has-error' : '')">
            <label>{{ field_label }}:</label>
            <div class="input-file input-file-image">
                <input type="file" @change="previewFilename(field_id)" class="form-control form-control-file" :id="field_id" :name="field_id" accept=""
                    required tabindex="4"> <div :id="'preview-label-'+field_id">{{ field_value }}</div>

                <label :for="field_id" class=" label-input-file btn btn-primary">Upload de arquivo</label>
            </div>
            
        </div>
    </div>
    <div v-else-if="type == 'textarea'" :class="'col-md-' + col_size">
        <div :class="'form-group ' + (errors != null ? 'has-error' : '')">
            <label>{{ field_label }}:</label>
            <textarea :name="field_id" class="form-control summernote" required :id="field_id" rows="5" tabindex="5">{{field_value}}</textarea>
            
        </div>
    </div>
    <div v-else :class="'col-md-' + col_size">
        <div :class="'form-group ' + (errors != null ? 'has-error' : '')">
            <label>{{ field_label }}:</label>
            <input :type="type" :name="field_id" class="form-control" :value="field_value" required>
            
        </div>
    </div>
</template>

<script>
export default {
    props: ['field_id', "required", 'type', 'field_label', 'field_value', 'errors', 'col_size', 'preview_size'],
    methods: {
        previewFilename(fieldId) {
            let field = document.getElementById(fieldId)
            let filename = field.files[0].name

            let previewLabel = document.getElementById('preview-label-'+fieldId)
            previewLabel.textContent = filename
        },
    },
    emits: {
        checkRequired(event) {
            if(this.required) {
                if(document.getElementById(this.field_id).value != null) {
                    event.validationPassed = false
                    alert(`Campo ${this.field_label} não pode ser vazio`)
                }
            }
        }
    }
}
</script>