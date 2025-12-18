import React from 'react';
import { Link } from '@inertiajs/react';
import { Head, useForm } from '@inertiajs/react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Textarea from '@/components/form/textarea';
import Button from '@/components/form/button';
import { __ } from '@/composables/translations';

export default function Broadcast(props) {

  const { data, setData, post, processing, errors } = useForm({
    message: '',
  });

  const handleChange = (event) => {
    setData(event.target.name, event.target.value);
  };

  const submit = (e) => {
    e.preventDefault();
    if (props.id === null) {
      console.log('broadcasting to all');
      post(route('broadcast'));
    }
    else {
      console.log(`broadcasting to ${props.id}`);
      post(route('broadcast-to-team', props.id));
    }
  };

  const title = (props.name !== null) ? __("broadcast_to", { team: props.name }) : __("Broadcast");
  const placeholder = ((props.name !== null) ? __("send_to", { team: props.name }) : __("send_to", { team: __("all teams") })).join("");

  return (
    <>
      <Head title={__("Broadcast")} />
      <Modal>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
            <Header title={title}>
              <p>{__("broadcast_message")}</p>
            </Header>
            <Errors errors={errors} />
            <Group onSubmit={submit}>
              <Textarea title={__("Message")} name="message" placeholder={placeholder} onChange={handleChange} required />
              <Button processing={processing}>{__("Send message")}</Button>
            </Group>
          </div>
        </div>
      </Modal>
    </>
  );
}
