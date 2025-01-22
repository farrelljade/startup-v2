import { router } from '@inertiajs/vue3';
import {useToast} from "vue-toastification";

export function sendToastNotification(type, message = '') {
    let toast = useToast();

    if (type === 'success') {
        toast.success(message);
    } else if (type === 'error') {
        toast.error(message);
    } else {
        toast.info(message);
    }
}

export function findErrorInResponse(error) {
    return error.response?.data?.error
        || error.response?.data?.message
        || error.response?.message
        || error.response?.error
        || 'An error has occurred. Please contact IT Development.';
}

export function updateProspect(prospectId, data, onSuccess) {
    return router.patch(
        route('prospects.update', { prospect: prospectId }),
        data,
        {
            onSuccess: () => {
                if (onSuccess) {
                    onSuccess();
                }
            },
            onError: (errors) => {
                console.error('Update failed:', errors);
            }
        }
    );
}

export function updateUser(userId, data, onSuccess) {
    return router.patch(
        route('users.update', { user: userId }),
        data,
        {
            onSuccess: () => {
                if (onSuccess) {
                    onSuccess();
                }
            },
            onError: (errors) => {
                console.error('Update failed:', errors);
            }
        }
    );
}

export function updateRecord(route, key, value, reload = false, notification = true, notificationMessage = null) {
    axios.patch(route,
        {[key]: value}
    ).then((result) => {
        if (notification) {
            let type = result.data.type ? result.data.type : 'success';
            sendToastNotification(type, notificationMessage ? notificationMessage : result.data.message)
        }

        if (reload) {
            window.location.reload();
        }
    }).catch(error => {
        sendToastNotification('error', findErrorInResponse(error))
    });
}

export function userHasPermission(user, permissionName) {
    if (!user) {
        return false;
    }

    if (user.is_admin) {
        return true;
    }

    return user.permissions?.some(permission => permission.name === permissionName) || false;
}

export function updateUserPermissions(userId, permissions, onSuccess) {
    return router.patch(
        route('users.permissions.update', { user: userId }),
        { permissions: permissions },
        {
            onSuccess: () => {
                if (onSuccess) {
                    onSuccess();
                }
            },
            onError: (errors) => {
                console.error('Update failed:', errors);
            }
        }
    );
}

export function createCookie(name, value, days) {
    let expires;

    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = `; expires=${date.toUTCString()}`;
    } else {
        expires = "";
    }
    document.cookie = `${name}=${value}${expires}; path=/`;
}

export function readCookie(name) {
    const nameEQ = encodeURIComponent(name) + "=";
    const ca = document.cookie.split(';');

    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ')
            c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0)
            return decodeURIComponent(c.substring(nameEQ.length, c.length));
    }
    return null;
}

export function logPhoneViewedAt(id, showState, routeName, columnName, notificationMessage = 'Request to view number logged!') {

    if (showState) {
        updateRecord(
            route(routeName, Array.isArray(id) ? id : [id]),
            columnName,
            new Date().toISOString(),
            false,
            true,
            notificationMessage
        );
    }
}
