import React from 'react';
import { Head, useForm } from '@inertiajs/react';
import Frame from '@/layouts/form/frame';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Input from '@/components/form/input';
import Button from '@/components/form/button';
import { __ } from '@/composables/translations';

export default function Login(props) {

  const { data, setData, post, processing, errors, reset } = useForm({
    username: '',
    password: '',
  });

  const handleChange = (event) => {
    setData(event.target.name, event.target.value);
  };

  const submit = (e) => {
    e.preventDefault();
    post(route('login'));
  };

  return (
    <>
      <Head title={__("Login")} />
      <div className="container max-w-screen-lg mx-auto">
        <Frame>
          <Header title={props.name} />
          <Errors errors={errors} />
          <Group onSubmit={submit}>
            <Input type="text" title={__("Username")} name="username" placeholder={__("Username")} onChange={handleChange} required />
            <Input type="password" title={__("Password")} name="password" placeholder={__("Password")} onChange={handleChange} required />
            <Button processing={processing}>{__("Login")}</Button>
          </Group>
        </Frame>
      </div>
    </>
  );
}
