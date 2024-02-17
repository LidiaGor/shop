import {usePage} from "@inertiajs/vue3";
export function can(permissionName) {
    return usePage().props.auth.permissions.indexOf(permissionName) > -1;
}

