import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Button from '@/components/form/button';

export default function DeleteUser({ id, username, canDelete }) {

  const { data, setData, post, processing, errors, reset } = useForm({
    id: id,
  });

  const deleteUser = (e) => {
    e.preventDefault();
    post(route('delete-user', id));
  }

  return (
    <>
      <Head title="Delete User" />
      <Modal back={route('users')}>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
            <Header title="Delete User">
              {canDelete &&
                <p className="text-red-500 font-medium">
                  Are you sure you want to delete user <span className="font-bold">{username}</span>?
                </p>
              }
              {!canDelete &&
                <p className="text-red-500 font-medium">
                  You cannot delete yourself!
                </p>
              }
            </Header>

            <Errors errors={errors} />

            {canDelete &&
              <Group onSubmit={deleteUser}>
                <input type="hidden" name="id" value={id} />
                <button
                  type="submit"
                  className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md
                font-semibold text-xs text-white uppercase tracking-widest">
                  Delete User
                </button>
              </Group>
            }
          </div>
        </div>
      </Modal>
    </>
  );
}
