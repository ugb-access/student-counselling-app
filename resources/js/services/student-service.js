import api from "@/config/api";
import { getLocalAuth } from "@/utils/local";

export const storeStudentDetail = (data) => {
    const auth_data = getLocalAuth();
    const formdata = new FormData();
    console.log(data.cv_path, data.passport, "passport");
    formdata.append("user_id", data.user_id);
    formdata.append("photo_path", data.photo_path);
    formdata.append("full_name", data.full_name);
    formdata.append("email", data.email);
    formdata.append("nationality", data.nationality);
    formdata.append("marital_status", data.marital_status);
    formdata.append("gender", data.gender);
    formdata.append("date_of_birth", data.date_of_birth);
    formdata.append("place_of_birth", data.place_of_birth);
    formdata.append("passport_no", data.passport_no);
    formdata.append("expiry_date", data.expiry_date);
    formdata.append("place_of_issue", data.place_of_issue);
    formdata.append("address", data.address);
    formdata.append("phone", data.phone);
    formdata.append("mobile", data.mobile);
    formdata.append("mobile_2", data.mobile_2);

    formdata.append("referee_name", data.referee_name);
    formdata.append("referee_mobile", data.referee_mobile);

    formdata.append("document_correction", data.document_correction);

    formdata.append(
        "education_history",
        JSON.stringify(data.education_history)
    );

    formdata.append("semester_year", data.semester_year);

    formdata.append("country_detail", JSON.stringify(data.country_detail));

    if (data.cv_path) {
        formdata.append("cv_path", data.cv_path[0]);
    }

    if (data.passport) {
        formdata.append("passport", data.passport[0]);
    }

    if (data.moi) {
        formdata.append("english_test[moi]", data.moi[0]);
    }
    if (data.english_proficiency) {
        formdata.append(
            "english_test[english_proficiency]",
            data.english_proficiency[0]
        );
    }
    if (data.ielts) {
        formdata.append("english_test[ielts]", data.ielts[0]);
    }
    if (data.other_english_test) {
        formdata.append(
            "english_test[other_english_test]",
            data.other_english_test[0]
        );
    }

    if (data.academic_document) {
        formdata.append("academic_document", data.academic_document[0]);
    }

    if (data.teacher_reference) {
        formdata.append("teacher_reference", data.teacher_reference[0]);
    }

    if (data.cnic) {
        formdata.append("cnic", data.cnic[0]);
    }

    if (data.experience_letter) {
        formdata.append("experience_letter", data.experience_letter[0]);
    }

    if (data.other_certificates) {
        formdata.append("other_certificates", data.other_certificates[0]);
    }

    if (data.conditional_offer) {
        formdata.append("conditional_offer", data.conditional_offer[0]);
    }

    if (data.unconditional_offer) {
        formdata.append(" unconditional_offer", data.unconditional_offer[0]);
    }

    if (data.payment_proof) {
        formdata.append("payment_proof", data.payment_proof[0]);
    }

    if (data.cas_ecoe) {
        formdata.append("cas_ecoe", data.cas_ecoe[0]);
    }
    if (data.visa) {
        formdata.append("visa", data.visa[0]);
    }

    if (data.travel_plan) {
        formdata.append("travel_plan", data.travel_plan[0]);
    }

    if (data.gt_document) {
        formdata.append("gt_document", data.gt_document[0]);
    }

    return api({
        method: "POST",
        url: "/student-detail",
        data: formdata,
        headers: {
            Authorization: "Bearer " + JSON.parse(auth_data).token,
            "Content-Type": "multipart/form-data",
        },
    });
};

export const getStudentDetail = (id) => {
    const auth_data = getLocalAuth();

    return api({
        method: "GET",
        url: `/student-detail/${id}`,
        headers: {
            Authorization: "Bearer " + JSON.parse(auth_data).token,
        },
    });
};

export const updateStudentData = ({ studentId, data }) => {
    const auth_data = getLocalAuth();
    const formdata = new FormData();

    if (data.photo_path) {
        formdata.append("photo_path", data.photo_path);
    }

    if (data.full_name) {
        formdata.append("full_name", data.full_name);
    }

    if (data.email) {
        formdata.append("email", data.email);
    }

    if (data.nationality) {
        formdata.append("nationality", data.nationality);
    }

    if (data.marital_status) {
        formdata.append("marital_status", data.marital_status);
    }

    if (data.gender) {
        formdata.append("gender", data.gender);
    }

    if (data.date_of_birth) {
        formdata.append("date_of_birth", data.date_of_birth);
    }

    if (data.place_of_birth) {
        formdata.append("place_of_birth", data.place_of_birth);
    }

    if (data.passport_no) {
        formdata.append("passport_no", data.passport_no);
    }

    if (data.expiry_date) {
        formdata.append("expiry_date", data.expiry_date);
    }

    if (data.address) {
        formdata.append("place_of_issue", data.place_of_issue);
    }

    if (data.photo_path) {
        formdata.append("address", data.address);
    }

    if (data.phone) {
        formdata.append("phone", data.phone);
    }

    if (data.mobile) {
        formdata.append("mobile", data.mobile);
    }

    if (data.mobile_2) {
        formdata.append("mobile_2", data.mobile_2);
    }

    if (data.referee_name) {
        formdata.append("referee_name", data.referee_name);
    }
    if (data.referee_mobile) {
        formdata.append("referee_mobile", data.referee_mobile);
    }
    if (data.document_correction) {
        formdata.append("document_correction", data.document_correction);
    }

    if (data.education_history) {
        formdata.append(
            "education_history",
            JSON.stringify(data.education_history)
        );
    }

    if (data.semester_year) {
        formdata.append("semester_year", data.semester_year);
    }
    if (data.country_detail) {
        formdata.append("country_detail", JSON.stringify(data.country_detail));
    }

    if (data.cv_path) {
        formdata.append("cv_path", data.cv_path[0]);
    }

    if (data.passport) {
        formdata.append("passport", data.passport[0]);
    }

    if (data.moi) {
        formdata.append("english_test[moi]", data.moi[0]);
    }
    if (data.english_proficiency) {
        formdata.append(
            "english_test[english_proficiency]",
            data.english_proficiency[0]
        );
    }
    if (data.ielts) {
        formdata.append("english_test[ielts]", data.ielts[0]);
    }
    if (data.other_english_test) {
        formdata.append(
            "english_test[other_english_test]",
            data.other_english_test[0]
        );
    }

    if (data.academic_document) {
        formdata.append("academic_document", data.academic_document[0]);
    }

    if (data.teacher_reference) {
        formdata.append("teacher_reference", data.teacher_reference[0]);
    }

    if (data.cnic) {
        formdata.append("cnic", data.cnic[0]);
    }

    if (data.experience_letter) {
        formdata.append("experience_letter", data.experience_letter[0]);
    }

    if (data.other_certificates) {
        formdata.append("other_certificates", data.other_certificates[0]);
    }

    if (data.conditional_offer) {
        formdata.append("conditional_offer", data.conditional_offer[0]);
    }

    if (data.unconditional_offer) {
        formdata.append(" unconditional_offer", data.unconditional_offer[0]);
    }

    if (data.payment_proof) {
        formdata.append("payment_proof", data.payment_proof[0]);
    }

    if (data.cas_ecoe) {
        formdata.append("cas_ecoe", data.cas_ecoe[0]);
    }
    if (data.visa) {
        formdata.append("visa", data.visa[0]);
    }

    if (data.travel_plan) {
        formdata.append("travel_plan", data.travel_plan[0]);
    }

    if (data.gt_document) {
        formdata.append("gt_document", data.gt_document[0]);
    }

    formdata.append("_method", "PATCH");

    return api({
        method: "POST",
        url: `/student-detail/${studentId}`,
        data: formdata,
        headers: {
            Authorization: "Bearer " + JSON.parse(auth_data).token,
            "Content-Type": "multipart/form-data",
        },
    });
};

