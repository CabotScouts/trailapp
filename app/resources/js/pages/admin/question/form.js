import React from 'react';
import { Link } from '@inertiajs/react';
import { Head, useForm } from '@inertiajs/react';
import { Modal } from '@/layouts/modal';
import Group from '@/layouts/form/group';
import Header from '@/components/form/header';
import Errors from '@/components/form/errors';
import Input from '@/components/form/input';
import Textarea from '@/components/form/textarea';
import Button from '@/components/form/button';

export default function AddQuestion(props) {

  const add = (props.data.name === null);
  const action = add ? 'Add' : 'Edit';

  const { data, setData, post, processing, errors, reset } = useForm({
    id: props.data.id || '',
    number: props.data.number || '',
    name: props.data.name || '',
    question: props.data.question || '',
    points: props.data.points || '',
  });

  const handleChange = (event) => {
    setData(event.target.name, event.target.value);
  };

  const submit = (e) => {
    e.preventDefault();
    if (add) {
      post(route('add-question'));
    }
    else {
      post(route('edit-question', props.data.id));
    }

  };

  return (
    <>
      <Head title={`${action} Question`} />
      <Modal>
        <div className="p-10 pt-20">
          <div className="p-5 bg-white rounded-xl shadow-lg w-full">
            <Header title={`${action} Question`} />
            <Errors errors={errors} />

            <Group onSubmit={submit}>
              <Input type="number" title="Question Number" name="number" placeholder="1" value={data.number} onChange={handleChange} required />
              <Input type="text" title="Question Name" name="name" placeholder="Name" value={data.name} onChange={handleChange} required />
              <Textarea title="Question" name="question" placeholder="What is the question?" value={data.question} onChange={handleChange} required />
              <Input type="number" title="Points" name="points" placeholder="1" value={data.points} onChange={handleChange} required />
              <Button processing={processing}>{`${action} Question`}</Button>
            </Group>
            {!add &&
              <div className="pt-2">
                <Link href={route('delete-question', props.data.id)} type="button" className="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest">Delete Question</Link>
              </div>
            }
          </div>
        </div>
      </Modal>
    </>
  );
}
