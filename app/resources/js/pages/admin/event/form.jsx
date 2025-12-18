import React from 'react';
import { Link } from '@inertiajs/react';
import { Head, useForm } from '@inertiajs/react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Input from '@/components/form/input';
import Button from '@/components/form/button';
import Select from '@/components/form/select';
import Checkbox from '@/components/form/checkbox';
import { __ } from '@/composables/translations';

export default function AddEvent(props) {

  const add = (props.event === false);
  const action = add ? __("Add Event") : __("Edit Event");

  const { data, setData, post, processing, errors, reset } = useForm({
    id: props.event.id || '',
    name: props.event.name || '',
    clone: false,
    clone_questions: true,
    clone_challenges: true,
    clone_groups: true,
  });

  const handleChange = (event) => {
    setData(event.target.name, event.target.value);
  };

  const handleCheckbox = (event) => {
    setData(event.target.name, !data[event.target.name]);
  }

  const submit = (e) => {
    e.preventDefault();
    if (add) {
      post(route('new-event'));
    }
    else {
      post(route('edit-event', props.event.id));
    }

  };

  return (
    <>
      <Head title={action} />
      <Modal back={route('events')}>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
            <Header title={action} />
            <Errors errors={errors} />

            <Group onSubmit={submit}>
              <Input type="text" title={__("Event Name")} name="name" placeholder={__("Name")} value={data.name} onChange={handleChange} required />
              {(add == true) &&
                <>
                  <Checkbox name="clone" label={__("Clone an existing event?")} onChange={handleCheckbox} defaultChecked={data.clone} />
                  <Select title={__("Event to clone")} name="clone_event_id" onChange={handleChange}>
                    <option value="-">{__("Select an Event")}</option>
                    {props.events.map(e => (<option key={e.id} value={e.id}>{e.name}</option>))}
                  </Select>
                  <Checkbox name="clone_questions" label={__("Clone questions")} onChange={handleCheckbox} defaultChecked={data.clone_questions} />
                  <Checkbox name="clone_challenges" label={__("Clone challenges")} onChange={handleCheckbox} defaultChecked={data.clone_challenges} />
                  <Checkbox name="clone_groups" label={__("Clone groups")} onChange={handleCheckbox} defaultChecked={data.clone_groups} />
                </>
              }
              <Button processing={processing}>{action}</Button>
            </Group>
            {(add == false) && (props.event.active == false) &&
              <div className="pt-2">
                <Link href={route('delete-event', props.event.id)} type="button" className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">{__("Delete Event")}</Link>
              </div>
            }
          </div>
        </div>
      </Modal>
    </>
  );
}
