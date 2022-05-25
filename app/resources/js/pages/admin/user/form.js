import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import { Head, useForm } from '@inertiajs/inertia-react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Input from '@/components/form/input';
import Button from '@/components/form/button';

export default function AddUser(props) {

  const add = (props.data.username === null);
  const action = add ? 'Add' : 'Edit';

  const { data, setData, post, processing, errors, reset } = useForm({
    id: props.data.id || '',
    username: props.data.username || '',
    password: '',
    confirm: '',
  });

  const handleChange = (event) => {
    setData(event.target.name, event.target.value);
  };

  const submit = (e) => {
    e.preventDefault();
    if(add) {
      post(route('add-user'));
    }
    else {
      post(route('edit-user', props.data.id));
    }

  };

  return (
    <>
      <Head title={`${ action } User`} />
      <Modal>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
          <Header title={`${ action } User`} />
          <Errors errors={ errors } />

          <Group onSubmit={ submit }>
            <Input type="text" title="Username" name="username" placeholder="Username" value={ data.username } onChange={ handleChange } required />
            <Input type="password" title="Password" name="password" placeholder="Password" onChange={ handleChange } required />
            <Input type="password" title="Confirm Password" name="password_confirmation" placeholder="Confirm Password" onChange={ handleChange } required />
            <Button processing={ processing }>{`${ action } User`}</Button>
          </Group>
          { !add && props.data.canDelete &&
            <div className="pt-2">
              <Link href={ route('delete-user', props.data.id) } type="button" className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">Delete User</Link>
            </div>
          }
          </div>
        </div>
      </Modal>
    </>
  );
}
