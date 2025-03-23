import { Dialog } from '@headlessui/react';
import { Fragment } from 'react';

type Props = {
    isOpen: boolean;
    onClose: () => void;
    onConfirm: () => void;
    title?: string;
    message?: string;
};

export default function ConfirmationModal({
    isOpen,
    onClose,
    onConfirm,
    title = 'Delete Confirmation',
    message = 'Are you sure you want to delete this item?',
}: Props) {
    return (
        <Dialog open={isOpen} onClose={onClose} as={Fragment}>
            <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                <Dialog.Panel className="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
                    <Dialog.Title className="text-lg font-semibold text-gray-800">
                        {title}
                    </Dialog.Title>
                    <div className="mt-2 text-sm text-gray-600">{message}</div>

                    <div className="mt-6 flex justify-end gap-2">
                        <button
                            onClick={onClose}
                            className="rounded border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                        >
                            Cancel
                        </button>
                        <button
                            onClick={onConfirm}
                            className="rounded bg-red-600 px-4 py-2 text-sm text-white hover:bg-red-700"
                        >
                            Delete
                        </button>
                    </div>
                </Dialog.Panel>
            </div>
        </Dialog>
    );
}
