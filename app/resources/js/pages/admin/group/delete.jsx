import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Button from '@/components/form/button';
import { __ } from '@/composables/translations';

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
      <Head title={__("Delete Group")} />
      <Modal back={route('groups')}>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
            <Header title={__("Delete Group")}>
              <p className="text-red-500 font-medium">
                {__("delete_group_check", { group: <span className="font-bold">{name}</span> })}
              </p>
            </Header>

            <Errors errors={errors} />

            <Group onSubmit={deleteGroup}>
              <input type="hidden" name="id" value={id} />
              <button type="submit" className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">{__("Delete Group")}</button>
            </Group>
          </div>
        </div>
      </Modal>
    </>
  );
}
