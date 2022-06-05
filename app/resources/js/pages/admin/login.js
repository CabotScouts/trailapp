import React from 'react';
import { Head, useForm } from '@inertiajs/inertia-react';
import Frame from '@/layouts/form/frame';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Input from '@/components/form/input';
import Button from '@/components/form/button';

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
      <Head title="Login" />
      <div className="container max-w-screen-lg mx-auto">
        <Frame>
          <Header title={ props.name } />
          <Errors errors={errors} />
          <Group onSubmit={ submit }>
            <Input type="text" title="Username" name="username" placeholder="Username" onChange={ handleChange } required />
            <Input type="password" title="Password" name="password" placeholder="Password" onChange={ handleChange } required />
            <Button processing={ processing }>Login</Button>
          </Group>
        </Frame>
      </div>
    </>
  );
}
