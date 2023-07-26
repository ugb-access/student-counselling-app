<script setup>
import avatar1 from "@images/avatars/avatar-1.png";
import router from "@/router";
import { toast } from "vue3-toastify";

const full_name = ref("");
const email = ref("");
const nationality = ref("");
const marital_status = ref("");
const gender = ref("");
const date_of_birth = ref("");
const place_of_birth = ref("");
const passport_no = ref("");
const expiry_date = ref("");
const place_of_issue = ref("");
const address = ref("");
const phone = ref("");
const mobile = ref("");
const mobile_2 = ref("");
const referee_name = ref("");
const referee_mobile = ref("");
const document_correction = ref("");
const education_history_obj = {
    course_name: "",
    from_date: "",
    to_date: "",
    institution_name: "",
    institution_grade: "",
};
const education_history = ref([education_history_obj]);

const semester_year = ref("");

const country_detail_obj = {
    c_course_name: "",
    c_name_of_country: "",
    c_name_of_institution: "",
    c_foundation: "",
};

const country_detail = ref([country_detail_obj]);

const cv_path = ref(null);
const passport = ref(null);
const moi = ref(null);
const english_proficiency = ref(null);
const ielts = ref(null);
const other_english_test = ref(null);
const academic_document = ref(null);
const teacher_reference = ref(null);
const cnic = ref(null);
const experience_letter = ref(null);
const other_certificates = ref(null);
const conditional_offer = ref(null);
const unconditional_offer = ref(null);
const payment_proof = ref(null);
const cas_ecoe = ref(null);
const visa = ref(null);
const travel_plan = ref(null);
const gt_document = ref(null);

const photo_path = ref({
    preview: "",
    file: "",
});

const date = ref();
const birthFlow = ref(["month", "year", "calendar"]);

const required = (value) => {
    if (!value?.trim()) return "Field is required";
};

const refInputEl = ref();

const changeAvatar = (event) => {
    const file = event.target.files[0];

    if (file) {
        photo_path.value.file = file;
        photo_path.value.preview = URL.createObjectURL(file);
    }
};

const handleSubmit = (e) => {
    console.log(
        photo_path.value,
        full_name.value,
        email.value,
        nationality.value,
        marital_status.value,
        gender.value,
        date_of_birth.value,
        place_of_birth.value,
        passport_no.value,
        expiry_date.value,
        place_of_issue.value,
        address.value,
        phone.value,
        mobile.value,
        mobile_2.value,
        referee_name.value,
        referee_mobile.value,
        document_correction.value,
        education_history.value,
        semester_year.value,
        country_detail.value,
        "Data",

        passport.value,
        moi.value,
        english_proficiency.value,
        ielts.value,
        other_english_test.value,
        academic_document.value,
        teacher_reference.value,
        cnic.value,
        experience_letter.value,
        other_certificates.value,
        conditional_offer.value,
        unconditional_offer.value,
        payment_proof.value,
        cas_ecoe.value,
        visa.value,
        travel_plan.value,
        gt_document.value
    );

    console.log(education_history, "education");
};

const addMoreCountryDetail = () => {
    if (country_detail.value.length < 4) {
        country_detail.value.push({ ...country_detail_obj });
    }
};

const addMoreEducation = () => {
    if (education_history.value.length < 4) {
        education_history.value.push({ ...education_history_obj });
    }
};

const handleFileChange = (e) => {
    console.log(e.target.files[0], e.target.name, "event");
};
</script>

<template>
    <VCard>
        <VForm @submit.prevent="handleSubmit" class="pa-4">
            <VCardText class="d-flex pl-0">
                <!-- 👉 Avatar -->
                <VCard
                    class="me-6 d-flex align-center justify-center"
                    width="100"
                    height="100"
                >
                    <span v-if="!photo_path.preview">PHOTO</span>
                    <VAvatar
                        size="100"
                        :image="photo_path.preview"
                        v-if="photo_path.preview"
                        rounded="0"
                    />
                </VCard>

                <!-- 👉 Upload Photo -->
                <form class="d-flex flex-column justify-center gap-5">
                    <div class="d-flex flex-wrap gap-2">
                        <VBtn color="primary" @click="refInputEl?.click()">
                            <VIcon
                                icon="mdi-cloud-upload-outline"
                                class="d-sm-none"
                            />
                            <span class="d-none d-sm-block"
                                >Upload new photo</span
                            >
                        </VBtn>

                        <input
                            ref="refInputEl"
                            type="file"
                            name="file"
                            accept=".jpeg,.png,.jpg"
                            hidden
                            @input="changeAvatar"
                            multiple="false"
                        />
                    </div>

                    <p class="text-body-1 mb-0">
                        Allowed JPG, GIF or PNG. Max size of 800K
                    </p>
                </form>
            </VCardText>

            <VRow>
                <!-- 👉 Name -->
                <VCol>
                    <!-- <div class="d-flex align-center">
                    <p class="text-lg ma-0 mr-2 font-weight-semibold">1.</p> -->

                    <VTextField
                        v-model="full_name"
                        placeholder="Full Name (as written on your passport)"
                        :rules="[required]"
                    >
                        <template v-slot:label>
                            <div>
                                Full Name (as written on your passport)
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>

                    <!-- </div> -->
                </VCol>
                <VCol>
                    <VTextField
                        v-model="email"
                        type="email"
                        label="Email"
                        placeholder="Email"
                        class="flex-1"
                        :rules="[required]"
                    >
                        <template v-slot:label>
                            <div>
                                Email
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>
            </VRow>

            <VRow>
                <VCol>
                    <VTextField
                        v-model="nationality"
                        type="text"
                        placeholder="Nationality"
                        :rules="[required]"
                        class="flex-1"
                    >
                        <template v-slot:label>
                            <div>
                                Nationality
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>

                <VCol cols="3">
                    <div class="d-flex align-center h-100">
                        <p class="mb-0 font-weight-bold mr-4">
                            Marital Status <span class="text-error">*</span> :
                        </p>
                        <VRadioGroup
                            v-model="marital_status"
                            inline=""
                            :rules="[required]"
                        >
                            <VRadio
                                label="Single"
                                value="1"
                                class="flex-0-0 mr-4"
                            />
                            <VRadio
                                label="Married"
                                value="2"
                                class="flex-0-0"
                            />
                        </VRadioGroup>
                    </div>
                </VCol>

                <VCol>
                    <div class="d-flex align-center h-100">
                        <p class="mb-0 font-weight-bold mr-4">
                            Gender <span class="text-error">*</span> :
                        </p>
                        <VRadioGroup
                            v-model="gender"
                            inline=""
                            :rules="[required]"
                        >
                            <VRadio
                                label="Male"
                                value="1"
                                class="flex-0-0 mr-4"
                            />
                            <VRadio label="Female" value="2" class="flex-0-0" />
                        </VRadioGroup>
                    </div>
                </VCol>
            </VRow>

            <VRow>
                <VCol>
                    <div>
                        <VueDatePicker
                            :enable-time-picker="false"
                            v-model="date_of_birth"
                            :max-date="new Date()"
                            placeholder="Date of Birth *"
                        />
                        <div
                            class="text-error text-caption"
                            v-if="!date_of_birth"
                        >
                            Field is required
                        </div>
                    </div>
                </VCol>

                <VCol>
                    <div>
                        <VueDatePicker
                            :enable-time-picker="false"
                            v-model="place_of_birth"
                            :max-date="new Date()"
                            placeholder="Place of Birth *"
                        />
                        <div
                            class="text-error text-caption"
                            v-if="!place_of_birth"
                        >
                            Field is required
                        </div>
                    </div>
                </VCol>
            </VRow>

            <VRow>
                <VCol>
                    <VTextField
                        v-model="passport_no"
                        type="text"
                        placeholder="Passport No"
                        :rules="[required]"
                        class="flex-1"
                    >
                        <template v-slot:label>
                            <div>
                                Passport No
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>
                <VCol>
                    <VTextField
                        v-model="expiry_date"
                        type="text"
                        placeholder="Date of Epiry"
                        :rules="[required]"
                        class="flex-1"
                    >
                        <template v-slot:label>
                            <div>
                                Date of Epiry
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>

                <VCol>
                    <VTextField
                        v-model="place_of_issue"
                        type="text"
                        label="Place of Issue"
                        placeholder="Place of Issue"
                        class="flex-1"
                    >
                    </VTextField>
                </VCol>
            </VRow>

            <VRow>
                <VCol>
                    <VTextField
                        v-model="address"
                        type="text"
                        placeholder="Address for Correspondence"
                        class="flex-1"
                        :rules="[required]"
                    >
                        <template v-slot:label>
                            <div>
                                Address for Correspondence
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>
            </VRow>

            <VRow>
                <VCol>
                    <VTextField
                        v-model="phone"
                        type="text"
                        label="Phone"
                        placeholder="Phone"
                        class="flex-1"
                        :rules="[required]"
                    >
                        <template v-slot:label>
                            <div>
                                Phone
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>

                <VCol>
                    <VTextField
                        v-model="mobile"
                        type="text"
                        label="Mobile"
                        placeholder="Mobile"
                        class="flex-1"
                        :rules="[required]"
                    >
                        <template v-slot:label>
                            <div>
                                Mobile
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>

                <VCol>
                    <VTextField
                        v-model="mobile_2"
                        type="text"
                        placeholder="Mobile 2"
                        class="flex-1"
                        :rules="[required]"
                    >
                        <template v-slot:label>
                            <div>
                                Mobile 2
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>
            </VRow>

            <VRow>
                <VCol>
                    <VTextField
                        v-model="referee_name"
                        type="text"
                        placeholder="Raferee Name"
                        class="flex-1"
                        :rules="[required]"
                    >
                        <template v-slot:label>
                            <div>
                                Referee Name
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>

                <VCol>
                    <VTextField
                        v-model="referee_mobile"
                        type="text"
                        placeholder="Raferee Mobile"
                        class="flex-1"
                        :rules="[required]"
                    >
                        <template v-slot:label>
                            <div>
                                Referee Mobile
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>
            </VRow>

            <VRow>
                <VCol>
                    <VTextField
                        v-model="document_correction"
                        type="text"
                        label="Any Correaction is required in your documents"
                        placeholder="Any Correction is required in your documents"
                        class="flex-1"
                    >
                    </VTextField>
                </VCol>
            </VRow>

            <h3 class="mb-2 mt-4 font-weight-medium">Education history:</h3>

            <VRow v-for="(item, index) in education_history" :key="index">
                <VCol>
                    <VTextField
                        v-model="item.course_name"
                        type="text"
                        placeholder="Name of Course"
                        class="flex-1"
                        :rules="[required]"
                    >
                        <template v-slot:label>
                            <div>
                                Name of Course
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>
                <VCol>
                    <VRow>
                        <p
                            class="d-flex align-center justify-center font-weight-medium mb-0 mr-2"
                        >
                            From:
                        </p>
                        <VCol class="d-flex align-center">
                            <div>
                                <VueDatePicker
                                    :enable-time-picker="false"
                                    v-model="item.from_date"
                                    :max-date="new Date()"
                                    placeholder="Start Date *"
                                    month-picker
                                />
                                <div
                                    class="text-error text-caption"
                                    v-if="!item.from_date"
                                >
                                    Field is required
                                </div>
                            </div>
                        </VCol>
                    </VRow>
                </VCol>

                <VCol>
                    <VRow>
                        <p
                            class="d-flex align-center justify-center font-weight-medium mb-0 ml-3 mr-2"
                        >
                            To:
                        </p>
                        <VCol class="d-flex align-center">
                            <div>
                                <VueDatePicker
                                    :enable-time-picker="false"
                                    v-model="item.to_date"
                                    :max-date="new Date()"
                                    placeholder="End Date *"
                                    month-picker
                                />
                                <div
                                    class="text-error text-caption"
                                    v-if="!item.to_date"
                                >
                                    Field is required
                                </div>
                            </div>
                        </VCol>
                    </VRow>
                </VCol>
                <VCol>
                    <VTextField
                        v-model="item.institution_name"
                        type="text"
                        placeholder="Name of Institution"
                        class="flex-1"
                        :rules="[required]"
                    >
                        <template v-slot:label>
                            <div>
                                Name of Institution
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>
                <VCol>
                    <VTextField
                        v-model="item.institution_grade"
                        type="text"
                        placeholder="Grade/CGPA/Percentage"
                        class="flex-1"
                        :rules="[required]"
                    >
                        <template v-slot:label>
                            <div>
                                Grade/CGPA/Percentage
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>
            </VRow>
            <VRow>
                <VCol class="d-flex flex-row-reverse py-0">
                    <VBtn
                        density="compact"
                        size="large"
                        variant="text"
                        @click="addMoreEducation"
                        >+Add More</VBtn
                    >
                </VCol>
            </VRow>

            <VRow>
                <VCol>
                    <div class="d-flex align-center h-100">
                        <p class="mb-0 font-weight-bold mr-4">
                            Proposed Year of Entry Semester
                            <span class="text-error">*</span> :
                        </p>
                        <VRadioGroup
                            v-model="semester_year"
                            inline=""
                            :rules="[required]"
                        >
                            <VRadio
                                label="Jan/Feb"
                                value="1"
                                class="flex-0-0 mr-4"
                            />
                            <VRadio
                                label="April/May"
                                value="2"
                                class="flex-0-0"
                            />
                            <VRadio
                                label="July/Aug"
                                value="3"
                                class="flex-0-0"
                            />
                            <VRadio
                                label="Sep/Oct"
                                value="4"
                                class="flex-0-0"
                            />
                        </VRadioGroup>
                    </div>
                </VCol>
            </VRow>

            <h3 class="mb-2 mt-4 font-weight-medium">
                Please give the name of the course, Institution, Country you are
                applying to:
            </h3>
            <VRow v-for="(item, index) in country_detail" :key="index">
                <VCol>
                    <VTextField
                        v-model="country_detail[index].c_course_name"
                        type="text"
                        placeholder="Name of Course"
                        class="flex-1"
                        :rules="[required]"
                    >
                        <template v-slot:label>
                            <div>
                                Name of Course
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>
                <VCol>
                    <VTextField
                        v-model="country_detail[index].c_name_of_country"
                        type="text"
                        placeholder="Name of Country"
                        class="flex-1"
                        :rules="[required]"
                    >
                        <template v-slot:label>
                            <div>
                                Name of Country
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>

                <VCol>
                    <VRow>
                        <p
                            class="d-flex align-center justify-center font-weight-medium mb-0 mr-2"
                        >
                            To:
                        </p>
                        <VCol class="d-flex align-center">
                            <VTextField
                                v-model="
                                    country_detail[index].c_name_of_institution
                                "
                                type="text"
                                placeholder="Name of Institution"
                                class="flex-1"
                                :rules="[required]"
                            >
                                <template v-slot:label>
                                    <div>
                                        Name of Institution
                                        <span class="text-error">*</span>
                                    </div>
                                </template>
                            </VTextField>
                        </VCol>
                    </VRow>
                </VCol>
                <VCol>
                    <VTextField
                        v-model="country_detail[index].c_foundation"
                        type="text"
                        placeholder="Foundation / UG / PG"
                        class="flex-1"
                        :rules="[required]"
                    >
                        <template v-slot:label>
                            <div>
                                Foundation / UG / PG
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
                </VCol>
            </VRow>

            <VRow>
                <VCol class="d-flex flex-row-reverse py-0">
                    <VBtn
                        density="compact"
                        size="large"
                        variant="text"
                        @click="addMoreCountryDetail"
                        >+Add More</VBtn
                    >
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <h3>Upload Your Documents</h3>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="cv_path"
                        label="Add your CV"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                        name="cv_path"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="passport"
                        name="passport"
                        label="Add your Passport"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <h4 className=" font-weight-medium ">English Tests</h4>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="moi"
                        name="moi"
                        label="Add your MOI"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="english_proficiency"
                        name="english_proficiency"
                        label="Add your English Proficiency"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="ielts"
                        name="ielts"
                        label="Add your IELTS"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="other_english_test"
                        name="other_english_test"
                        label="Add your Other English Test"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow>
                <VCol>
                    <h4 className=" font-weight-medium ">Academic Document</h4>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="academic_document"
                        name="academic_document"
                        label="Add your Academic Document"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow>
                <VCol>
                    <h4 className=" font-weight-medium ">Teacher Reference</h4>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="teacher_reference"
                        name="teacher_reference"
                        label="Add your Teacher References"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <h4 className=" font-weight-medium ">Other Documents</h4>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="cnic"
                        name="cnic"
                        label="Add your CNIC"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="experience_letter"
                        name="experience_letter"
                        label="Add your Experience Letter"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="other_certificates"
                        name="other_certificates"
                        label="Add your Other Certificates"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="conditional_offer"
                        name="conditional_offer"
                        label="Add your Conditional Offer"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="unconditional_offer"
                        name="unconditional_offer"
                        label="Add your Unconditional Offer"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="payment_proof"
                        name="payment_proof"
                        label="Add your Payment Proof"
                        placeholder="Select your files"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="cas_ecoe"
                        name="cas_ecoe"
                        label="Add your CAS / eCoE"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="visa"
                        name="visa"
                        label="Add your Visa file"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="travel_plan"
                        name="travel_plan"
                        label="Add your Travel Plan"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow>
                <VCol>
                    <h4 className=" font-weight-medium ">GT Document</h4>
                </VCol>
            </VRow>

            <VRow>
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="gt_document"
                        name="gt_document"
                        label="Add your GT File"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleFileChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <!-- 👉 Email -->
            <VRow>
                <VCol cols="12" class="d-flex gap-4">
                    <VBtn type="submit"> Submit </VBtn>
                    <VBtn type="reset" color="secondary" variant="tonal">
                        Reset
                    </VBtn>
                </VCol>
            </VRow>
        </VForm>
    </VCard>
</template>

<style>
.dp__input_icon_pad {
    padding-top: 14px;
    padding-bottom: 14px;
}
</style>
