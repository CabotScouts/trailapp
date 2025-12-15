import React from 'react';
import { Link } from '@inertiajs/react';
import { Head, useForm } from '@inertiajs/react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Textarea from '@/components/form/textarea';
import Button from '@/components/form/button';

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

  const name = (props.name !== null) ? props.name : 'all teams';
  const title = (props.name !== null) ? ` to ${props.name}` : '';

  return (
    <>
      <Head title="Broadcast" />
      <Modal>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
            <Header title={`Broadcast${title}`}>
              <p><span className="italic">Broadcast</span> instantly sends a message to teams - use with care, and check your message for mistakes!</p>
            </Header>
            <Errors errors={errors} />
            <Group onSubmit={submit}>
              <Textarea title="Message" name="message" placeholder={`Send a message to ${name}`} onChange={handleChange} required />
              <Button processing={processing}>Broadcast</Button>
            </Group>
          </div>
        </div>
      </Modal>
    </>
  );
}
