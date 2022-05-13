import React from 'react';
import { Head, useForm } from '@inertiajs/inertia-react';
import Frame from '@/layouts/form/frame';
import InputGroup from '@/layouts/form/group';
import Header from '@/components/form/header';
import ValidationErrors from '@/components/form/validationerrors';
import Input from '@/components/form/input';
import SelectInput from '@/components/form/select';
import Button from '@/components/form/button';

export default function Start(props) {

  const { data, setData, post, processing, errors, reset } = useForm({
    group: '',
    name: '',
  });

  const handleChange = (event) => {
    setData(event.target.name, event.target.value);
  };

  const submit = (e) => {
    e.preventDefault();
    post(route('create-team'));
  };

  return (
    <>
      <Head title="Create a team" />
      <Frame>
        <Header title={ props.name }>
          <p>Pick your Scout Group and decide on a team name to start the trail</p>
        </Header>

        <ValidationErrors errors={errors} />

        <InputGroup onSubmit={ submit }>
          <SelectInput title="Scout Group" name="group" placeholder="Select your Group" onChange={ handleChange } required>
            { props.groups.map(g => (<option key={ g.id } value={ g.id }>{ g.name }</option>)) }
          </SelectInput>
          <Input type="text" title="Team Name" name="name" placeholder="Pick a team name" onChange={ handleChange } required />
          <Button processing={ processing }>Start Trail</Button>
        </InputGroup>
      </Frame>
    </>
  );
}
