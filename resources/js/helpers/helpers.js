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
