<script setup>
import avatar1 from "@images/avatars/avatar-1.png";

import { toast } from "vue3-toastify";
import {
    storeStudentDetail,
    getStudentDetail,
    updateStudentData,
} from "@/services/student-service";

import { useRoute } from "vue-router";
import { dashFormat } from "@/utils/date";
import { onMounted } from "vue";

import router from "@/router";

const props = defineProps({
    readonly: String,
    data: Object,
});

const { readonly, data } = toRefs(props);
const route = useRoute();

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

const updateObj = ref({});

const photo_path = ref({
    preview: "",
    file: "",
});

const loading = ref(false);

const edit = ref(false);

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

    if (edit) {
        updateObj.value["photo_path"] = event.target.files;
    }
};

const handleSubmit = (e) => {
    

    if (edit.value) {
        if (Object.keys(updateObj.value).length) {
            loading.value = true;
            const data = updateObj.value;
            updateStudentData({ studentId: route.params.id, data })
                .then((res) => {
                    const id = route.params.id;
                    window.location.href = `/student/view/${id}`;
                    toast.success("Student Details Updated Successfully!");
                })
                .catch((err) => {
                    if (err.response.data.error) {
                        toast.error(err.response.data.error);
                    }
                })
                .finally((res) => {
                    loading.value = false;
                });
        } else {
            toast.error("No Changes has been made!");
        }
    } else {
        if (!photo_path.value.file) {
            toast.error("Student Photo is required!");
            return false;
        } else if (!full_name.value.trim()) {
            toast.error("Full Name is required!");
            return false;
        } else if (!email.value.trim()) {
            toast.error("Email is required!");
            return false;
        } else if (!nationality.value.trim()) {
            toast.error("Nationality is required!");
            return false;
        } else if (!marital_status.value) {
            toast.error("Marital Status is required!");
            return false;
        } else if (!gender.value) {
            toast.error("Gender is required!");
            return false;
        } else if (!date_of_birth.value) {
            toast.error("Date of Birth is required!");
            return false;
        } else if (!place_of_birth.value) {
            toast.error("Place of Birth is required!");
            return false;
        } else if (!passport_no.value.trim()) {
            toast.error("Passport is required!");
            return false;
        } else if (!expiry_date.value) {
            toast.error("Expiry Date is required!");
            return false;
        } else if (!address.value.trim()) {
            toast.error("Address is required!");
            return false;
        } else if (!phone.value.trim()) {
            toast.error("Phone No. is required!");
            return false;
        } else if (!mobile.value.trim()) {
            toast.error("Mobile No. is required!");
            return false;
        } else if (!mobile_2.value.trim()) {
            toast.error("Mobile 2 is required!");
            return false;
        } else if (!referee_name.value.trim()) {
            toast.error("Referee Name is required!");
            return false;
        } else if (
            education_history.value.length == 0 ||
            !Object.values(education_history.value[0]).every((value) => value)
        ) {
            toast.error("Education History is required!");
            return false;
        } else if (!semester_year.value) {
            toast.error("Semester Year is required!");
            return false;
        } else if (
            country_detail.value.length === 0 ||
            !Object.values(country_detail.value[0]).every((value) => value)
        ) {
            toast.error("Country Detail is required!");
            return false;
        }
        loading.value = true;
        const data = {
            user_id: route.params.id,
            photo_path: photo_path.value.file,
            full_name: full_name.value,
            email: email.value,
            nationality: nationality.value,
            marital_status: marital_status.value,
            gender: gender.value,
            date_of_birth: dashFormat(date_of_birth.value),
            place_of_birth: place_of_birth.value,
            passport_no: passport_no.value,
            expiry_date: dashFormat(expiry_date.value),
            place_of_issue: place_of_issue.value,
            address: address.value,
            phone: phone.value,
            mobile: mobile.value,
            mobile_2: mobile_2.value,
            referee_name: referee_name.value,
            referee_mobile: referee_mobile.value,
            document_correction: document_correction.value,
            education_history: education_history.value,
            semester_year: semester_year.value,
            country_detail: country_detail.value,
            cv_path: cv_path.value,
            passport: passport.value,

            moi: moi.value,
            english_proficiency: english_proficiency.value,
            ielts: ielts.value,
            other_english_test: other_english_test.value,

            academic_document: academic_document.value,
            teacher_reference: teacher_reference.value,
            cnic: cnic.value,
            experience_letter: experience_letter.value,
            other_certificates: other_certificates.value,
            conditional_offer: conditional_offer.value,
            unconditional_offer: unconditional_offer.value,
            payment_proof: payment_proof.value,
            cas_ecoe: cas_ecoe.value,
            visa: visa.value,
            travel_plan: travel_plan.value,
            gt_document: gt_document.value,
        };

        storeStudentDetail(data)
            .then((res) => {
                const id = route.params.id;
                window.location.href = `/student/view/${id}`;
                toast.success("Student Details Added Successfully!");
            })
            .catch((err) => {
                if (err.response.data.error) {
                    toast.error(err.response.data.error);
                }
            })
            .finally((res) => {
                loading.value = false;
            });
    }
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

const handleChange = (e) => {
    
    if (edit) {
        const { name, value } = e.target;
        if (value) {
            if (name === "education_history") {
                updateObj.value[name] = education_history.value;
            } else if (name === "country_detail") {
                updateObj.value[name] = country_detail.value;
            } else {
                if (e.target.type === "file") {
                    updateObj.value[name] = e.target.files;
                } else {
                    if (e.target.type === "radio") {
                        updateObj.value[name] = Number(e.target.value);
                    } else {
                        updateObj.value[name] = e.target.value;
                    }
                }
            }

            // if (name === "cv_path") {
            //     cv_path.value = e.target.files;
            // } else if (name === "passport") {
            //     passport.value = e.target.files;
            // } else if (name === "academic_document") {
            //     academic_document.value = e.target.files;
            // } else if (name === "teacher_reference") {
            //     teacher_reference.value = e.target.files;
            // } else if (name === "cnic") {
            //     cnic.value = e.target.files;
            // } else if (name === "experience_letter") {
            //     experience_letter.value = e.target.files;
            // } else if (name === "other_certificates") {
            //     other_certificates.value = e.target.files;
            // } else if (name === "conditional_offer") {
            //     conditional_offer.value = e.target.files;
            // } else if (name === "unconditional_offer") {
            //     unconditional_offer.value = e.target.files;
            // } else if (name === "payment_proof") {
            //     payment_proof.value = e.target.files;
            // } else if (name === "cas_ecoe") {
            //     cas_ecoe.value = e.target.files;
            // } else if (name === "visa") {
            //     visa.value = e.target.files;
            // } else if (name === "travel_plan") {
            //     travel_plan.value = e.target.files;
            // } else if (name === "gt_document") {
            //     gt_document.value = e.target.files;
            // } else if (name === "moi") {
            //     moi.value = e.target.files;
            // } else if (name === "english_proficiency") {
            //     english_proficiency.value = e.target.files;
            // } else if (name === "ielts") {
            //     ielts.value = e.target.files;
            // } else if (name === "other_english_test") {
            //     other_english_test.value = e.target.files;
            // }
        }
    }
};

const fetchStudentDetail = () => {
    
    if (data.value) {
        photo_path.value.preview = data.value.student.photo_path;
        full_name.value = data.value.student.full_name;
        email.value = data.value.student.email;
        nationality.value = data.value.student.nationality;
        marital_status.value = data.value.student.marital_status.toString();
        gender.value = data.value.student.gender.toString();
        date_of_birth.value = data.value.student.date_of_birth;
        place_of_birth.value = data.value.student.place_of_birth;
        passport_no.value = data.value.student.passport_no;
        expiry_date.value = data.value.student.expiry_date;
        place_of_issue.value = data.value.student.place_of_issue;
        address.value = data.value.student.address;
        phone.value = data.value.student.phone;
        mobile.value = data.value.student.mobile;
        mobile_2.value = data.value.student.mobile_2;
        referee_name.value = data.value.student.referee_name;
        referee_mobile.value = data.value.student.referee_mobile;
        document_correction.value = data.value.student.document_correction;

        education_history.value = data.value.student.education_history;

        semester_year.value = data.value.student.semester_year.toString();

        country_detail.value = data.value.student.country_detail;

        cv_path.value = data.value.student.cv_path;
        passport.value = data.value.student.passport;
        academic_document.value = data.value.student.academic_document;
        teacher_reference.value = data.value.student.teacher_reference;
        cnic.value = data.value.student.cnic;
        experience_letter.value = data.value.student.experience_letter;
        other_certificates.value = data.value.student.other_certificates;
        conditional_offer.value = data.value.student.conditional_offer;
        unconditional_offer.value = data.value.student.unconditional_offer;
        payment_proof.value = data.value.student.payment_proof;
        cas_ecoe.value = data.value.student.cas_ecoe;
        visa.value = data.value.student.visa;
        travel_plan.value = data.value.student.travel_plan;
        gt_document.value = data.value.student.gt_document;

        moi.value = data.value.student.english_test?.moi;
        english_proficiency.value =
            data.value.student.english_test?.english_proficiency;
        ielts.value = data.value.student.english_test?.ielts;
        other_english_test.value =
            data.value.student.english_test?.other_english_test;
    }
};

onMounted(fetchStudentDetail);

const handleRemove = (name) => {
    if (name === "cv_path") {
        cv_path.value = "";
    } else if (name === "passport") {
        passport.value = "";
    } else if (name === "academic_document") {
        academic_document.value = "";
    } else if (name === "teacher_reference") {
        teacher_reference.value = "";
    } else if (name === "cnic") {
        cnic.value = "";
    } else if (name === "experience_letter") {
        experience_letter.value = "";
    } else if (name === "other_certificates") {
        other_certificates.value = "";
    } else if (name === "conditional_offer") {
        conditional_offer.value = "";
    } else if (name === "unconditional_offer") {
        unconditional_offer.value = "";
    } else if (name === "payment_proof") {
        payment_proof.value = "";
    } else if (name === "cas_ecoe") {
        cas_ecoe.value = "";
    } else if (name === "visa") {
        visa.value = "";
    } else if (name === "travel_plan") {
        travel_plan.value = "";
    } else if (name === "gt_document") {
        gt_document.value = "";
    } else if (name === "moi") {
        moi.value = "";
    } else if (name === "english_proficiency") {
        english_proficiency.value = "";
    } else if (name === "ielts") {
        ielts.value = "";
    } else if (name === "other_english_test") {
        other_english_test.value = "";
    }
};

const dateOfBirthClosed = () => {
    if (edit) {
        updateObj.value["date_of_birth"] = dashFormat(date_of_birth.value);
    }
};

const expiryDateClosed = () => {
    if (edit) {
        updateObj.value["expiry_date"] = dashFormat(expiry_date.value);
    }
};
const educationHistoryClosed = () => {
    if (edit) {
        updateObj.value["education_history"] = education_history.value;
    }
};
</script>

<template>
    <VCard :loading="loading">
        <template
            v-slot:title
            v-if="
                readonly === 'true' &&
                (!cv_path ||
                    !passport ||
                    !academic_document ||
                    !teacher_reference ||
                    !cnic ||
                    !experience_letter ||
                    !other_certificates ||
                    !conditional_offer ||
                    !unconditional_offer ||
                    !payment_proof ||
                    !cas_ecoe ||
                    !visa ||
                    !travel_plan ||
                    !gt_document ||
                    (!moi &&
                        !english_proficiency &&
                        !ielts &&
                        !other_english_test))
            "
        >
            <v-alert density="compact" type="warning">
                <template v-slot:text>
                    <v-expansion-panels style="color: aliceblue">
                        <v-expansion-panel
                            title="Some Files are Missing. See Detail"
                            style="color: aliceblue; background-color: #ffb400"
                        >
                            <template v-slot:text>
                                <ul
                                    class="ml-5"
                                    style="background-color: #ffb400"
                                >
                                    <li v-if="!cv_path">Cv File is Missing.</li>
                                    <li v-if="!passport">
                                        Passport File is Missing.
                                    </li>
                                    <li v-if="!academic_document">
                                        Academic Documents File is Missing.
                                    </li>
                                    <li v-if="!teacher_reference">
                                        Teacher Reference is Missing.
                                    </li>
                                    <li v-if="!cnic">CNIC File is Missing.</li>
                                    <li v-if="!experience_letter">
                                        Experience Letter File is Missing.
                                    </li>
                                    <li v-if="!conditional_offer">
                                        Conditional Offer File is Missing.
                                    </li>
                                    <li v-if="!unconditional_offer">
                                        Unconditional Offer File is Missing.
                                    </li>
                                    <li v-if="!visa">
                                        Payment Proof File is Missing.
                                    </li>
                                    <li v-if="!cas_ecoe">
                                        Cas/Ecoe File is Missing.
                                    </li>
                                    <li v-if="!visa">Visa File is Missing.</li>
                                    <li v-if="!travel_plan">
                                        Travel Plan File is Missing.
                                    </li>
                                    <li v-if="!gt_document">
                                        GT Document File is Missing.
                                    </li>

                                    <li v-if="!gt_document">
                                        GT Document File is Missing.
                                    </li>
                                    <li
                                        v-if="
                                            !moi &&
                                            !english_proficiency &&
                                            !ielts &&
                                            !other_english_test
                                        "
                                    >
                                        English Tests File is Missing.
                                    </li>
                                </ul>
                            </template>
                        </v-expansion-panel>
                    </v-expansion-panels>
                </template>
            </v-alert>
        </template>
        <VForm @submit.prevent="handleSubmit" class="pa-4">
            <div class="d-flex justify-space-between align-center">
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
                    <form
                        class="d-flex flex-column justify-center gap-5"
                        v-if="readonly !== 'true' || edit === true"
                    >
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
                <VBtn
                    color="primary"
                    text
                    @click="() => (edit = true)"
                    class="action-button"
                    target="_blank"
                    v-if="readonly === 'true'"
                    >Edit</VBtn
                >
            </div>

            <VRow>
                <!-- 👉 Name -->
                <VCol>
                    <!-- <div class="d-flex align-center">
                    <p class="text-lg ma-0 mr-2 font-weight-semibold">1.</p> -->

                    <VTextField
                        v-model="full_name"
                        placeholder="Full Name (as written on your passport)"
                        :rules="[required]"
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="full_name"
                        @input="handleChange"
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="email"
                        @input="handleChange"
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="nationality"
                        @input="handleChange"
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
                            :variant="
                                readonly === 'true' && edit === false
                                    ? 'solo'
                                    : 'outlined'
                            "
                            :readonly="readonly === 'true' && edit === false"
                            name="marital_status"
                            @change="handleChange"
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
                            :variant="
                                readonly === 'true' && edit === false
                                    ? 'solo'
                                    : 'outlined'
                            "
                            :readonly="readonly === 'true' && edit === false"
                            name="gender"
                            @change="handleChange"
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
                            :readonly="readonly === 'true' && edit === false"
                            :class="{
                                dateDisabled:
                                    readonly === 'true' && edit === false,
                            }"
                            name="date_of_birth"
                            @closed="dateOfBirthClosed"
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
                    <VTextField
                        v-model="place_of_birth"
                        type="text"
                        placeholder="Place Of Birth"
                        :rules="[required]"
                        class="flex-1"
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="place_of_birth"
                        @input="handleChange"
                    >
                        <template v-slot:label>
                            <div>
                                Place of Birth
                                <span class="text-error">*</span>
                            </div>
                        </template>
                    </VTextField>
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="passport_no"
                        @input="handleChange"
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
                    <div>
                        <VueDatePicker
                            :enable-time-picker="false"
                            v-model="expiry_date"
                            placeholder="Date of Expiry"
                            :readonly="readonly === 'true' && edit === false"
                            :class="{
                                dateDisabled:
                                    readonly === 'true' && edit === false,
                            }"
                            @closed="expiryDateClosed"
                        />
                        <div
                            class="text-error text-caption"
                            v-if="!expiry_date"
                        >
                            Field is required
                        </div>
                    </div>
                </VCol>

                <VCol>
                    <VTextField
                        v-model="place_of_issue"
                        type="text"
                        label="Place of Issue"
                        placeholder="Place of Issue"
                        class="flex-1"
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="place_of_issue"
                        @input="handleChange"
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="address"
                        @input="handleChange"
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="phone"
                        @input="handleChange"
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="mobile"
                        @input="handleChange"
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="mobile_2"
                        @input="handleChange"
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="referee_name"
                        @input="handleChange"
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="referee_mobile"
                        @input="handleChange"
                    />
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="document_correction"
                        @input="handleChange"
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="education_history"
                        @input="handleChange"
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
                                    :readonly="
                                        readonly === 'true' && edit === false
                                    "
                                    :class="{
                                        dateDisabled:
                                            readonly === 'true' &&
                                            edit === false,
                                    }"
                                    name="education_history"
                                    @closed="educationHistoryClosed"
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
                                    :readonly="
                                        readonly === 'true' && edit === false
                                    "
                                    :class="{
                                        dateDisabled:
                                            readonly === 'true' &&
                                            edit === false,
                                    }"
                                    name="education_history"
                                    @closed="educationHistoryClosed"
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="education_history"
                        @input="handleChange"
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="education_history"
                        @input="handleChange"
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
                        v-if="readonly !== 'true'"
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
                            :variant="
                                readonly === 'true' && edit === false
                                    ? 'solo'
                                    : 'outlined'
                            "
                            :readonly="readonly === 'true' && edit === false"
                            name="semester_year"
                            @change="handleChange"
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="country_detail"
                        @input="handleChange"
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="country_detail"
                        @input="handleChange"
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
                        <VCol class="d-flex align-center">
                            <VTextField
                                v-model="
                                    country_detail[index].c_name_of_institution
                                "
                                type="text"
                                placeholder="Name of Institution"
                                class="flex-1"
                                :rules="[required]"
                                :variant="
                                    readonly === 'true' && edit === false
                                        ? 'solo'
                                        : 'outlined'
                                "
                                :readonly="
                                    readonly === 'true' && edit === false
                                "
                                name="country_detail"
                                @input="handleChange"
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
                        :variant="
                            readonly === 'true' && edit === false
                                ? 'solo'
                                : 'outlined'
                        "
                        :readonly="readonly === 'true' && edit === false"
                        name="country_detail"
                        @input="handleChange"
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
                        v-if="readonly !== 'true'"
                        >+Add More</VBtn
                    >
                </VCol>
            </VRow>

            <VRow v-if="readonly !== 'true'">
                <VCol>
                    <h3>Upload Your Documents</h3>
                </VCol>
            </VRow>
            <VRow v-if="readonly !== 'true'">
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="cv_path"
                        label="Add your CV"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        name="cv_path"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && cv_path">
                <VCol>
                    <h3 class="mb-2">Cv</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            CV -
                            {{
                                cv_path?.includes?.("s3.amazonaws")
                                    ? cv_path
                                    : cv_path[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="cv_path"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="() => handleRemove('cv_path')"
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="cv_path"
                                    class="action-button"
                                    target="_blank"
                                    v-if="cv_path?.includes?.('s3.amazonaws')"
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !cv_path && edit">
                <VCol>
                    <VFileInput
                        accept=".pdf"
                        v-model="cv_path"
                        label="Add your CV"
                        placeholder="Select your file"
                        prepend-icon="mdi-paperclip"
                        variant="outlined"
                        :show-size="1000"
                        @change="handleChange"
                        name="cv_path"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow v-if="readonly === 'true' && passport">
                <VCol>
                    <h3 class="mb-2">Passport</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            Passport -
                            {{
                                passport?.includes?.("s3.amazonaws")
                                    ? passport
                                    : passport[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="passport"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="() => handleRemove('passport')"
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="passport"
                                    class="action-button"
                                    target="_blank"
                                    v-if="passport?.includes?.('s3.amazonaws')"
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !passport && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow v-if="readonly !== 'true'">
                <VCol>
                    <h4 className=" font-weight-medium ">English Tests</h4>
                </VCol>
            </VRow>
            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow
                v-if="
                    readonly === 'true' &&
                    (moi || english_proficiency || ielts || other_english_test)
                "
            >
                <VCol>
                    <h4 className=" font-weight-medium ">English Tests</h4>
                </VCol>
            </VRow>
            <VRow v-if="readonly === 'true' && moi">
                <VCol>
                    <h3 class="mb-2">MOI</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            MOI -
                            {{
                                moi?.includes?.("s3.amazonaws")
                                    ? moi
                                    : moi[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="moi"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="() => handleRemove('moi')"
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="moi"
                                    class="action-button"
                                    target="_blank"
                                    v-if="moi?.includes?.('s3.amazonaws')"
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>
            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && english_proficiency">
                <VCol>
                    <h3 class="mb-2">English Proficiency</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            English Proficiency -
                            {{
                                english_proficiency?.includes?.("s3.amazonaws")
                                    ? english_proficiency
                                    : english_proficiency[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="english_proficiency"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="
                                        () =>
                                            handleRemove('english_proficiency')
                                    "
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="english_proficiency"
                                    class="action-button"
                                    target="_blank"
                                    v-if="
                                        english_proficiency?.includes?.(
                                            's3.amazonaws'
                                        )
                                    "
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>
            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && ielts">
                <VCol>
                    <h3 class="mb-2">IELTS</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            IELTS -
                            {{
                                ielts?.includes?.("s3.amazonaws")
                                    ? ielts
                                    : ielts[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="ielts"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="() => handleRemove('ielts')"
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="ielts"
                                    class="action-button"
                                    target="_blank"
                                    v-if="ielts?.includes?.('s3.amazonaws')"
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>
            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && other_english_test">
                <VCol>
                    <h3 class="mb-2">Other English Test</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            Other English Test -
                            {{
                                other_english_test?.includes?.("s3.amazonaws")
                                    ? other_english_test
                                    : other_english_test[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="other_english_test"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="
                                        () => handleRemove('other_english_test')
                                    "
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="other_english_test"
                                    class="action-button"
                                    target="_blank"
                                    v-if="
                                        other_english_test?.includes?.(
                                            's3.amazonaws'
                                        )
                                    "
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow
                v-if="
                    readonly === 'true' &&
                    edit &&
                    !moi &&
                    !english_proficiency &&
                    !ielts &&
                    !other_english_test
                "
            >
                <VCol>
                    <h4 className=" font-weight-medium ">English Tests</h4>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !moi && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !english_proficiency && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !ielts && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !other_english_test && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly !== 'true'">
                <VCol>
                    <h4 className=" font-weight-medium ">Academic Document</h4>
                </VCol>
            </VRow>
            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && academic_document">
                <VCol>
                    <h3 class="mb-2">Academic Document</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            Academic Document -
                            {{
                                academic_document?.includes?.("s3.amazonaws")
                                    ? academic_document
                                    : academic_document[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="academic_document"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="
                                        () => handleRemove('academic_document')
                                    "
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="academic_document"
                                    class="action-button"
                                    target="_blank"
                                    v-if="
                                        academic_document?.includes?.(
                                            's3.amazonaws'
                                        )
                                    "
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !academic_document && edit">
                <VCol>
                    <h4 className=" font-weight-medium ">Academic Document</h4>
                </VCol>
            </VRow>
            <VRow v-if="readonly === 'true' && !academic_document && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly !== 'true'">
                <VCol>
                    <h4 className=" font-weight-medium ">Teacher Reference</h4>
                </VCol>
            </VRow>
            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && teacher_reference">
                <VCol>
                    <h3 class="mb-2">Teacher Reference</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            Teacher Reference -
                            {{
                                teacher_reference?.includes?.("s3.amazonaws")
                                    ? teacher_reference
                                    : teacher_reference[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="teacher_reference"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="
                                        () => handleRemove('teacher_reference')
                                    "
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="teacher_reference"
                                    class="action-button"
                                    target="_blank"
                                    v-if="
                                        teacher_reference?.includes?.(
                                            's3.amazonaws'
                                        )
                                    "
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !teacher_reference && edit">
                <VCol>
                    <h4 className=" font-weight-medium ">Teacher Reference</h4>
                </VCol>
            </VRow>
            <VRow v-if="readonly === 'true' && !teacher_reference && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly !== 'true'">
                <VCol>
                    <h4 className=" font-weight-medium ">Other Documents</h4>
                </VCol>
            </VRow>
            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow
                v-if="
                    readonly === 'true' &&
                    (cnic ||
                        experience_letter ||
                        experience_letter ||
                        other_certificates ||
                        conditional_offer ||
                        unconditional_offer ||
                        cas_ecoe ||
                        payment_proof ||
                        visa ||
                        travel_plan)
                "
            >
                <VCol>
                    <h4 className=" font-weight-medium ">Other Documents</h4>
                </VCol>
            </VRow>
            <VRow v-if="readonly === 'true' && cnic">
                <VCol>
                    <h3 class="mb-2">CNIC</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            CNIC -
                            {{
                                cnic?.includes?.("s3.amazonaws")
                                    ? cnic
                                    : cnic[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="cnic"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="() => handleRemove('cnic')"
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="cnic"
                                    class="action-button"
                                    target="_blank"
                                    v-if="cnic?.includes?.('s3.amazonaws')"
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow
                v-if="
                    readonly === 'true' &&
                    edit &&
                    !cnic &&
                    !experience_letter &&
                    !experience_letter &&
                    !other_certificates &&
                    !conditional_offer &&
                    !unconditional_offer &&
                    !cas_ecoe &&
                    !payment_proof &&
                    !visa &&
                    !travel_plan
                "
            >
                <VCol>
                    <h4 className=" font-weight-medium ">Other Documents</h4>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !cnic && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && experience_letter">
                <VCol>
                    <h3 class="mb-2">Experience Letter</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            Experience Letter -
                            {{
                                experience_letter?.includes?.("s3.amazonaws")
                                    ? experience_letter
                                    : experience_letter[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="experience_letter"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="
                                        () => handleRemove('experience_letter')
                                    "
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="experience_letter"
                                    class="action-button"
                                    target="_blank"
                                    v-if="
                                        experience_letter?.includes?.(
                                            's3.amazonaws'
                                        )
                                    "
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !experience_letter && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow v-if="readonly === 'true' && other_certificates">
                <VCol>
                    <h3 class="mb-2">Other Certificates</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            Other Certificates -
                            {{
                                other_certificates?.includes?.("s3.amazonaws")
                                    ? other_certificates
                                    : other_certificates[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="other_certificates"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="
                                        () => handleRemove('other_certificates')
                                    "
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="other_certificates"
                                    class="action-button"
                                    target="_blank"
                                    v-if="
                                        other_certificates?.includes?.(
                                            's3.amazonaws'
                                        )
                                    "
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !other_certificates && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && conditional_offer">
                <VCol>
                    <h3 class="mb-2">Conditional Offer</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            Conditional Offer -
                            {{
                                conditional_offer?.includes?.("s3.amazonaws")
                                    ? conditional_offer
                                    : conditional_offer[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="conditional_offer"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="
                                        () => handleRemove('conditional_offer')
                                    "
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="conditional_offer"
                                    class="action-button"
                                    target="_blank"
                                    v-if="
                                        conditional_offer?.includes?.(
                                            's3.amazonaws'
                                        )
                                    "
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !conditional_offer && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && unconditional_offer">
                <VCol>
                    <h3 class="mb-2">Unconditional Offer</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            Unconditional Offer -
                            {{
                                unconditional_offer?.includes?.("s3.amazonaws")
                                    ? unconditional_offer
                                    : unconditional_offer[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="unconditional_offer"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="
                                        () =>
                                            handleRemove('unconditional_offer')
                                    "
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="unconditional_offer"
                                    class="action-button"
                                    target="_blank"
                                    v-if="
                                        unconditional_offer?.includes?.(
                                            's3.amazonaws'
                                        )
                                    "
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !unconditional_offer && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && payment_proof">
                <VCol>
                    <h3 class="mb-2">Payment Proof</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            Payment Proof -
                            {{
                                payment_proof?.includes?.("s3.amazonaws")
                                    ? payment_proof
                                    : payment_proof[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="payment_proof"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="() => handleRemove('payment_proof')"
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="payment_proof"
                                    class="action-button"
                                    target="_blank"
                                    v-if="
                                        payment_proof?.includes?.(
                                            's3.amazonaws'
                                        )
                                    "
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !payment_proof && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && cas_ecoe">
                <VCol>
                    <h3 class="mb-2">CAS/ECOE</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            CAS/ECOE -
                            {{
                                cas_ecoe?.includes?.("s3.amazonaws")
                                    ? cas_ecoe
                                    : cas_ecoe[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="cas_ecoe"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="() => handleRemove('cas_ecoe')"
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="cas_ecoe"
                                    class="action-button"
                                    target="_blank"
                                    v-if="cas_ecoe?.includes?.('s3.amazonaws')"
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !cas_ecoe && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && visa">
                <VCol>
                    <h3 class="mb-2">Visa</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            Visa -
                            {{
                                visa?.includes?.("s3.amazonaws")
                                    ? visa
                                    : visa[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="visa"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="() => handleRemove('visa')"
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="visa"
                                    class="action-button"
                                    target="_blank"
                                    v-if="visa?.includes?.('s3.amazonaws')"
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !visa && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && travel_plan">
                <VCol>
                    <h3 class="mb-2">Travel Plan</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            Travel Plan -
                            {{
                                travel_plan?.includes?.("s3.amazonaws")
                                    ? travel_plan
                                    : travel_plan[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="travel_plan"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="() => handleRemove('travel_plan')"
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="travel_plan"
                                    class="action-button"
                                    target="_blank"
                                    v-if="
                                        travel_plan?.includes?.('s3.amazonaws')
                                    "
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !travel_plan && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <VRow v-if="readonly !== 'true'">
                <VCol>
                    <h4 className=" font-weight-medium ">GT Document</h4>
                </VCol>
            </VRow>

            <VRow v-if="readonly !== 'true'">
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
                    >
                    </VFileInput>
                </VCol>
            </VRow>
            <VRow v-if="readonly === 'true' && gt_document">
                <VCol>
                    <h4 className=" font-weight-medium ">GT Document</h4>
                </VCol>
            </VRow>
            <VRow v-if="readonly === 'true' && gt_document">
                <VCol>
                    <h3 class="mb-2">GT Document</h3>
                    <VCard class="py-2 px-2">
                        <div class="d-flex align-center justify-space-between">
                            GT Document -
                            {{
                                gt_document?.includes?.("s3.amazonaws")
                                    ? gt_document
                                    : gt_document[0].name
                            }}
                            <div>
                                <VBtn
                                    color="primary"
                                    text
                                    name="gt_document"
                                    class="action-button mr-2"
                                    v-if="edit"
                                    @click="() => handleRemove('gt_document')"
                                    >Delete</VBtn
                                >
                                <VBtn
                                    color="primary"
                                    text
                                    :href="gt_document"
                                    class="action-button"
                                    target="_blank"
                                    v-if="
                                        gt_document?.includes?.('s3.amazonaws')
                                    "
                                    >View</VBtn
                                >
                            </div>
                        </div>
                    </VCard>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !gt_document && edit">
                <VCol>
                    <h4 className=" font-weight-medium ">GT Document</h4>
                </VCol>
            </VRow>

            <VRow v-if="readonly === 'true' && !gt_document && edit">
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
                        @change="handleChange"
                    >
                    </VFileInput>
                </VCol>
            </VRow>

            <!-- 👉 Email -->
            <VRow v-if="readonly !== 'true' || edit === true">
                <VCol cols="12" class="d-flex gap-4">
                    <VBtn type="submit" :disabled="loading"> Submit </VBtn>
                    <VBtn
                        type="reset"
                        :disabled="loading"
                        color="secondary"
                        variant="tonal"
                        v-if="readonly !== 'true'"
                    >
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

.dateDisabled {
    box-shadow: 0 3px 1px -2px var(--v-shadow-key-umbra-opacity),
        0 2px 2px 0 var(--v-shadow-key-penumbra-opacity),
        0 1px 5px 0 var(--v-shadow-key-ambient-opacity);
}

.dateDisabled .dp__input {
    border: 0px;
}

.v-expansion-panel-title {
    padding: 6px !important;
    min-height: 0 !important;
}
</style>
