import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Button from '@/components/form/button';
import { __ } from '@/composables/translations';

export default function DeleteTeam({ id, name }) {

  const { data, setData, post, processing, errors, reset } = useForm({
    id: id,
  });

  const deleteTeam = (e) => {
    e.preventDefault();
    post(route('delete-team', id));
  }

  return (
    <>
      <Head title={__("Delete Team")} />
      <Modal back={route('teams')}>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
            <Header title={__("Delete Team")}>
              <p className="text-red-500 font-medium">{__("delete_team_check", { team: <span className="font-bold">{name}</span> })}</p>
            </Header>

            <Errors errors={errors} />

            <Group onSubmit={deleteTeam}>
              <input type="hidden" name="id" value={id} />
              <button type="submit" className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">{__("Delete Team")}</button>
            </Group>
          </div>
        </div>
      </Modal>
    </>
  );
}
