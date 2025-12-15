import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Input from '@/components/form/input';
import Button from '@/components/form/button';
import Select from '@/components/form/select';

export default function EditTeam(props) {

  const { data, setData, post, processing, errors, reset } = useForm({
    id: props.team.id,
    name: props.team.name,
    group: props.team.group_id,
  });

  const handleChange = (event) => {
    setData(event.target.name, event.target.value);
  };

  const submit = (e) => {
    e.preventDefault();
    post(route('edit-team', props.team.id));
  };


  return (
    <>
      <Head title="Edit Team" />
      <Modal>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
            <Header title="Edit Team" />
            <Errors errors={errors} />

            <Group onSubmit={submit}>
              <Input type="text" title="Team Name" name="name" value={data.name} onChange={handleChange} required />
              <Select title="Group" name="group" defaultValue={data.group} onChange={handleChange}>
                {props.groups.map(g => (<option key={g.id} value={g.id}>{g.name}</option>))}
              </Select>
              <Button processing={processing}>Edit Team</Button>
            </Group>
          </div>
        </div>
      </Modal>
    </>
  );
}
