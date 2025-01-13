import { router } from '@inertiajs/vue3';

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
