import api from "@/config/api";
import { getLocalAuth } from "@/utils/local";

// Get
export const getAllAdmins = ({ limit = null }) => {
	const auth_data = getLocalAuth();

	return api({
		method: "get",
		url: "/admin/list",
		params: {
			limit: limit || undefined,
		},
		headers: {
			Authorization: `Bearer ${JSON.parse(auth_data).token}`,
		},
	});
};

export const getAllCounsellor = ({ limit = null, search = null, page = 1 }) => {
	const auth_data = getLocalAuth();

	return api({
		method: "get",
		url: "/counsellor/list",
		params: {
			limit: limit || undefined,
			search: search || undefined,
			page,
		},
		headers: {
			Authorization: `Bearer ${JSON.parse(auth_data).token}`,
		},
	});
};

export const getAllStudents = ({
	limit = null,
	page = null,
	status = null,
	search = null,
	counsellor_id = null,
}) => {
	const auth_data = getLocalAuth();

	return api({
		method: "get",
		url: "/student/list",
		params: {
			limit: limit || undefined,
			page: page || undefined,
			status: status || undefined,
			search: search?.trim?.() ?? undefined,
			counsellor_id: counsellor_id || undefined,
		},
		headers: {
			Authorization: `Bearer ${JSON.parse(auth_data).token}`,
		},
	});
};

// POST

export const addAdmin = ({ username, email, name, password }) => {
	const auth_data = getLocalAuth();

	return api({
		method: "POST",
		url: "/add-admin",
		data: {
			username,
			email,
			name,
			password,
		},
		headers: {
			Authorization: `Bearer ${JSON.parse(auth_data).token}`,
		},
	});
};

export const addCounsellor = ({
	username,
	email,
	name,
	password,
	phone_number,
}) => {
	const auth_data = getLocalAuth();

	return api({
		method: "POST",
		url: "/add-counsellor",
		data: {
			username,
			email,
			name,
			password,
			phone_number,
		},
		headers: {
			Authorization: `Bearer ${JSON.parse(auth_data).token}`,
		},
	});
};

export const addStudent = ({
	username,
	email,
	name,
	password,
	phone_number,
	counsellor_id,
}) => {
	const auth_data = getLocalAuth();

	return api({
		method: "POST",
		url: "/add-student",
		data: {
			username,
			email,
			name,
			password,
			phone_number,
			counsellor_id,
		},
		headers: {
			Authorization: `Bearer ${JSON.parse(auth_data).token}`,
		},
	});
};

export const getUserCount = () => {
	const auth_data = getLocalAuth();

	return api({
		method: "get",
		url: "/user-count",
		headers: {
			Authorization: `Bearer ${JSON.parse(auth_data).token}`,
		},
	});
};

export const getProfileData = (id) => {
	const auth_data = getLocalAuth();
	return api({
		method: "get",
		url: `/get-profile/${id}`,
		headers: {
			Authorization: `Bearer ${JSON.parse(auth_data).token}`,
		},
	});
};

export const updateProfile = (data) => {
	const auth_data = getLocalAuth();
	return api({
		method: "patch",
		url: `/update-profile`,
		data,
		headers: {
			Authorization: `Bearer ${JSON.parse(auth_data).token}`,
		},
	});
};

export const updateUserProfile = (id, data) => {
	const auth_data = getLocalAuth();
	return api({
		method: "patch",
		url: `/update-user-profile/${id}`,
		data,
		headers: {
			Authorization: `Bearer ${JSON.parse(auth_data).token}`,
		},
	});
};

export const deleteUserProfile = (id) => {
	const auth_data = getLocalAuth();
	return api({
		method: "delete",
		url: `/delete-user-profile/${id}`,
		headers: {
			Authorization: `Bearer ${JSON.parse(auth_data).token}`,
		},
	});
};
