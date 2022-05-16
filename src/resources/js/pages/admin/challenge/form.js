import React from 'react';
import { Link } from '@inertiajs/inertia-react';
import { Head, useForm } from '@inertiajs/inertia-react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Input from '@/components/form/input';
import Textarea from '@/components/form/textarea';
import Button from '@/components/form/button';

export default function AddChallenge(props) {

  const add = (props.data.name === null);
  const action = add ? 'Add' : 'Edit';

  const { data, setData, post, processing, errors, reset } = useForm({
    id: props.data.id || '',
    name: props.data.name || '',
    description: props.data.description || '',
    points: props.data.points || '',
  });

  const handleChange = (event) => {
    setData(event.target.name, event.target.value);
  };

  const submit = (e) => {
    e.preventDefault();
    if(add) {
      post(route('add-challenge'));
    }
    else {
      post(route('edit-challenge', props.data.id));
    }
    
  };

  return (
    <>
      <Head title={`${ action } Challenge`} />
      <Modal>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
          <Header title={`${ action } Challenge`} />
          <Errors errors={errors} />
          
          <Group onSubmit={ submit }>
            <Input type="text" title="Challenge Name" name="name" placeholder="Name" value={ data.name } onChange={ handleChange } required />
            <Textarea title="Description" name="description" placeholder="Describe the challenge" value={ data.description } onChange={ handleChange } required />
            <Input type="number" title="Points" name="points" placeholder="1" value={ data.points } onChange={ handleChange } required />
            <Button processing={ processing }>{`${ action } Challenge`}</Button>
          </Group>
          { !add && 
            <div className="pt-2">
              <Link href={ route('delete-challenge', props.data.id) } type="button" className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">Delete Challenge</Link>
            </div>
          }
          </div>
        </div>
      </Modal>
    </>
  );
}
