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

export function userHasPermission(user, permissionName) {
    // If user is admin, they have all permissions
    if (user.is_admin) {
        return true;
    }

    // Check if user has the specific permission
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
