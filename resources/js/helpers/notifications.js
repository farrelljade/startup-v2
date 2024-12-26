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
