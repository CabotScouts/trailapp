import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Button from '@/components/form/button';

export default function DeleteGroup({ id, name }) {

  const { data, setData, post, processing, errors, reset } = useForm({
    id: id,
  });

  const deleteGroup = (e) => {
    e.preventDefault();
    post(route('delete-group', id));
  }

  return (
    <>
      <Head title="Delete Group" />
      <Modal back={route('groups')}>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
            <Header title="Delete Group">
              <p className="text-red-500 font-medium">Are you sure you want to delete group <span className="font-bold">{name}</span>? This will delete all teams (and all submissions) associated with it.</p>
            </Header>

            <Errors errors={errors} />

            <Group onSubmit={deleteGroup}>
              <input type="hidden" name="id" value={id} />
              <button type="submit" className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">Delete Group</button>
            </Group>
          </div>
        </div>
      </Modal>
    </>
  );
}
